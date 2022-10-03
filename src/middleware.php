<?php

// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);


$app->add(new Tuupola\Middleware\JwtAuthentication([
    // "header" => "X-Token", // para usar esse parametro e necessario alterar na aba Authorization / X-Token
    "regexp" => "/(.*)/",
    "path" => "/api", /* or ["/api", "/admin"] */
    "ignore" => ["/api/token"],
    "secret" => $container->get('settings')['secretKey']
]));



$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    // print_r($response);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});
