protected $routeMiddleware = [
    // Other middleware
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'auth' => \App\Http\Middleware\Authenticate::class,
];
