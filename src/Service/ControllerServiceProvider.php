<?php

namespace Api\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Controller\BeerController;

class ControllerServiceProvider implements ServiceProviderInterface
{
	public function register(Container $app)
	{
		$app['beers'] = function(Container $app){
			return new BeerController($app);
		};
	}
}
