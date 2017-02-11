<?php

namespace Api\Service;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RouterServiceProvider implements ServiceProviderInterface
{
	public function register(Container $app)
	{
		/**
		 * Home Route
		 */
		$app->get('/', 'home:index');
	}	
}
