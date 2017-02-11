<?php

namespace Api\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Controller\HomeController;

class ControllerServiceProvider implements ServiceProviderInterface
{
	public function register(Container $app)
	{
		$app['home'] = function(Container $app){
			return new HomeController($app);
		};
	}
}
