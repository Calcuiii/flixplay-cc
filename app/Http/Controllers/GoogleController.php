<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    // 1. Fungsi untuk melempar user ke halaman Login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Fungsi untuk menerima user yang sudah login dari Google
    public function handleGoogleCallback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek 1: Apakah user ini sudah pernah login pakai Google sebelumnya?
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // Jika SUDAH ada, langsung login
                Auth::login($user);
                return redirect()->route('dashboard');
            } else {
                // Jika BELUM, cek apakah emailnya sudah terdaftar di database?
                $existingUser = User::where('email', $googleUser->email)->first();

                if ($existingUser) {
                    // Cek 2: Email sudah ada (tapi dulu daftar manual), kita sambungkan akunnya
                    $existingUser->update(['google_id' => $googleUser->id]);
                    Auth::login($existingUser);
                } else {
                    // Cek 3: User benar-benar baru, buatkan akun baru
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make(Str::random(16)), // Buat password acak agar aman
                        'email_verified_at' => now(), // Anggap email Google sudah valid
                    ]);
                    Auth::login($newUser);
                }

                return redirect()->route('dashboard');
            }

        } catch (\Exception $e) {
            // Jika user membatalkan login atau ada error lain
            return redirect()->route('login')->with('error', 'Login Google Gagal atau Dibatalkan.');
        }
    }
}
