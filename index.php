<?php

require_once __DIR__.'/vendor/autoload.php';

$router = new AltoRouter();

$router->map('GET', '/', function() {
    require __DIR__ . '/views/home.php';
});

$router->map('GET', '/student/[i:id]', function($id) {
	require __DIR__ . '/students/results.php';
});


// match current request url
$match = $router->match();

// call closure or throw 404 status
if( is_array($match) && is_callable( $match['target'] ) ) {
	call_user_func_array( $match['target'], $match['params'] );
} else {
	// no route was matched
	header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
