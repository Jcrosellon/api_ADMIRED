<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Otros middleware ya existentes

    protected $middleware = [
        // Otros middleware
        \app\Http\Middleware\Cors::class,
    ];

    // Otros códigos y configuraciones en el Kernel
}
