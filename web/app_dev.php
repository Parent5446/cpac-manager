<?php

use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

// This check prevents access to debug front controllers that are deployed
// by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
if ( isset( $_SERVER[ 'HTTP_CLIENT_IP' ] )
	|| isset( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] )
	|| !( in_array( $_SERVER[ 'REMOTE_ADDR' ], [ '127.0.0.1', 'fe80::1', '::1' ] )
		|| PHP_SAPI === 'cli-server' )
) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit(
		'You are not allowed to access this file. Check '
			. basename( __FILE__ )
			. ' for more information.'
	);
}

$loader = require_once __DIR__ . '/../var/bootstrap.php.cache';
Debug::enable();

require_once __DIR__ . '/../app/AppKernel.php';

$kernel = new AppKernel( 'dev', true );
$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle( $request );
$response->send();
$kernel->terminate( $request, $response );
