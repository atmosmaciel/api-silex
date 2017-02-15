<?php

namespace Api\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

class BaseController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function returnResponse($response, $code)
    {
        $response = new Response($response, $code);

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getDoctrineService()
    {
        $getDoctrineService = $this->app['orm.em'];
        return $getDoctrineService;
    }
}
