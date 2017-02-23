<?php

namespace Api\Service;

use Pimple\Container;
use Api\Controller\Beer;
use Api\Controller\User;
use Pimple\ServiceProviderInterface;

class ControllerServiceProvider implements ServiceProviderInterface
{
	public function register(Container $app)
	{
		$app['beers'] = function(Container $app){
			return new Beer($app);
		};

        $app['users'] = function(Container $app){
            return new User($app);
        };
	}
}
