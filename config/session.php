<?php

use Illuminate\Support\Str;

return [

  
    'driver' => env('SESSION_DRIVER', 'database'),

   
    'lifetime' => (int) env('SESSION_LIFETIME', 120),

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),


    'encrypt' => env('SESSION_ENCRYPT', false),

    
    'files' => storage_path('framework/sessions'),

   

    'connection' => env('SESSION_CONNECTION'),


    'table' => env('SESSION_TABLE', 'sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | When using one of the framework's cache driven session backends, you may
    | define the cache store which should be used to store the session data
    | between requests. This must match one of your defined cache stores.
    |
    | Affects: "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */

    'lottery' => [2, 100],

    

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug((string) env('APP_NAME', 'laravel')).'-session'
    ),

   

    'path' => env('SESSION_PATH', '/'),

    

    'domain' => env('SESSION_DOMAIN'),

   

    'secure' => env('SESSION_SECURE_COOKIE'),

    
    'http_only' => env('SESSION_HTTP_ONLY', true),

   

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

    

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),

];
