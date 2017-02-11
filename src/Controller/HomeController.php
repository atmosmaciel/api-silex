<?php

namespace Api\Controller;

use Silex\Application;

class HomeController
{
	private $app;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function index()
	{
		return "ok";
	}

}