<?php

namespace BabeRuka\SystemRoles\Http;

use Illuminate\Foundation\Http\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    protected $middleware = [ 
    ];

    protected $middlewareGroups = [
        'web' => [ 
        ],

        'api' => [ 
        ],
    ];

    
    protected $middlewareAliases = [ 
    ];

    protected $routeMiddleware = [ 
    ];

}
