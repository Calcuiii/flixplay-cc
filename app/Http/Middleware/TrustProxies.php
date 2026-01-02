<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Proxy yang dipercaya untuk aplikasi ini.
     * Menggunakan '*' berarti mempercayai semua proxy (cocok untuk Azure/AWS).
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*'; // <--- PASTIKAN INI ADALAH '*'

    /**
     * Header yang harus digunakan untuk mendeteksi proxy.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
