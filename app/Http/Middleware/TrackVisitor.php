<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteVisit; // Pastikan Model ini sudah ada
use Illuminate\Support\Facades\DB;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek 1: Pastikan bukan request API/JSON (hanya halaman web biasa)
        // Cek 2: Pastikan method-nya GET (jangan hitung saat POST form)
        if (!$request->expectsJson() && $request->isMethod('get')) {

            $today = now()->toDateString();

            try {
                // Simpan ke database
                SiteVisit::updateOrCreate(
                    ['visit_date' => $today],
                    ['count' => DB::raw('count + 1')]
                );
            } catch (\Exception $e) {
                // Jika error database, biarkan aplikasi tetap jalan (jangan crash)
                // Log error jika perlu: \Log::error($e->getMessage());
            }
        }

        return $next($request);
    }
}
