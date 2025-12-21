<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;


class PaymentController extends Controller
{
    private $serverKey;
    private $clientKey;
    private $merchantId;
    private $snapUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->merchantId = config('midtrans.merchant_id');
        $this->snapUrl = config('midtrans.snap_url');
    }

    public function process(Request $request, SubscriptionPlan $plan)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ((int)$plan->price === 0) {
            Subscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'status' => 'completed',
                'started_at' => now(),
                'expires_at' => now()->addDays($plan->duration_days),
                'amount' => 0,
            ]);

            return redirect()->route('subscription.success')
                ->with('success', 'Berhasil menggunakan paket Free');
        }

        // 🔐 Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'ORDER-' . $user->id . '-' . time();

        Subscription::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'status' => 'pending',
            'midtrans_order_id' => $orderId,
            'amount' => $plan->price,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $plan->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => [
                [
                    'id' => $plan->id,
                    'price' => (int) $plan->price,
                    'quantity' => 1,
                    'name' => 'Subscription ' . $plan->name,
                ]
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return redirect("https://app.sandbox.midtrans.com/snap/v4/redirection/$snapToken");
    }


    // Callback dari Midtrans (setelah user selesai payment)
    public function callback(Request $request)
    {
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $transactionStatus = $request->input('transaction_status');
        $serverKey = $this->serverKey;

        // Verify signature dari Midtrans
        $signature = hash('sha512', $orderId . $statusCode . $request->input('gross_amount') . $serverKey);

        if ($signature !== $request->input('signature_key')) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Find subscription by order ID
        $subscription = Subscription::where('midtrans_order_id', $orderId)->first();

        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        // Update subscription status berdasarkan payment status
        if ($transactionStatus === 'capture' || $transactionStatus === 'settlement') {
            // Payment berhasil
            $subscription->update([
                'status' => 'completed',
                'transaction_id' => $request->input('transaction_id'),
                'started_at' => now(),
                'expires_at' => now()->addDays($subscription->plan->duration_days),
            ]);

            // Update user subscription
            $user = $subscription->user;
            $user->update([
                'subscription_type' => $subscription->plan->name,
                'subscription_expires_at' => $subscription->expires_at,
            ]);
        } elseif ($transactionStatus === 'deny' || $transactionStatus === 'cancel') {
            $subscription->update(['status' => 'failed']);
        } elseif ($transactionStatus === 'pending') {
            $subscription->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'Callback processed']);
    }

    // Finish payment (user klik "Selesai" di payment gateway)
    public function finish(Request $request)
    {
        $orderId = $request->input('order_id');
        $subscription = Subscription::where('midtrans_order_id', $orderId)->first();

        if ($subscription && $subscription->status === 'completed') {
            return redirect()->route('subscription.success')->with('success', 'Pembayaran berhasil! Subscription Anda sudah aktif.');
        } else {
            return redirect()->route('subscription.failed')->with('error', 'Pembayaran sedang diproses atau gagal.');
        }
    }

    public function error(Request $request)
    {
        return redirect()->route('subscription.failed')->with('error', 'Pembayaran dibatalkan.');
    }

    public function success()
    {
        return view('subscription.success');
    }

    public function failed()
    {
        return view('subscription.failed');
    }

    public function pending()
    {
        return view('subscription.pending');
    }
}