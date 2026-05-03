<?php

namespace App\Http\Middleware;

class TrustProxies
{
    protected $proxies = '*';
    protected $headers = \Illuminate\Http\Request::HEADER_X_FORWARDED_ALL;
}
