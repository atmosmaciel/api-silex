<?php

namespace Api\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterServiceProvider implements ServiceProviderInterface
{
	public function register(Container $app)
	{
        $main_url = '/beers';

		/**
		 * Main Route
		 */
		$app->get($app['api_version'] . $main_url, 'beers:index');

        /**
         * Get Beer ID
         */
		$app->get($app['api_version'] . $main_url . '/{id}', 'beers:getBeer');

//		$app->after(function (Request $request, Response $response){
//            $response->headers->set('Content-Type', 'application/json');
//        });
	}    
}
