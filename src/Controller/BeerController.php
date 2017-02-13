<?php

namespace Api\Controller;

use JMS\Serializer\SerializerBuilder;

class BeerController extends BaseController
{
    public function index()
    {
        $beers = $this->app['orm.em']
                      ->getRepository('Api\Model\Beer')
                      ->findAll();

        $beers = SerializerBuilder::create()->build()->serialize($beers, 'json');

        return $this->returnResponse($beers, 200);
    }
}
