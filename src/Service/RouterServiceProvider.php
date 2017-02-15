<?php

namespace Api\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;

class RouterServiceProvider implements ServiceProviderInterface
{
	public function register(Container $app)
	{
        $beers_url = '/beers/';

		$app->get($app['api_version'] . $beers_url, 'beers:get');

		$app->get($app['api_version'] . $beers_url . '{id}', 'beers:get');

		$app->post($app['api_version'] . $beers_url, 'beers:create');

		$app->put($app['api_version'] . $beers_url, 'beers:update');

		$app->delete($app['api_version'] . $beers_url . '{id}', 'beers:delete');

//		$app->after(function (Request $request, Response $response){
//            $response->headers->set('Content-Type', 'application/json');
//      });

	}    
}
