<?php

namespace Api\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Controller\Beer;
use Api\Controller\User;

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
