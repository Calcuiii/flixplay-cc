<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSubscriptionActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // ❌ BUKAN subscription_expires_at
        // ✅ SESUAI MIGRATION
        if (
            $user->subscription_status !== 'premium' ||
            !$user->premium_expires_at
        ) {
            return redirect()
                ->route('subscription.plans')
                ->with('error', 'Silakan berlangganan untuk menonton film ini.');
        }

        // Subscription expired
        if (now()->greaterThan($user->premium_expires_at)) {

            // auto downgrade
            $user->update([
                'subscription_status' => 'free',
                'premium_expires_at' => null,
            ]);

            return redirect()
                ->route('subscription.plans')
                ->with('error', 'Subscription Anda telah berakhir. Silakan perpanjang.');
        }

        return $next($request);
    }
}
    