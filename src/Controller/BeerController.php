<?php

namespace Api\Controller;

use Api\Model\Beer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;

class BeerController extends BaseController
{
    public function getBeer($id = null)
    {
        $beers = $this->app['orm.em']
                      ->getRepository('Api\Model\Beer');

        if (is_null($id)){
            $beers = $beers->findAll();
        } else {
            $id = (int) $id;
            $beers = $beers->find($id);
        }

        /*
         * Quando o ORM Doctrine retorna os dados do Banco ele retorna como um Objeto.
         * Assim fica cimplexo manipular os dados retornados.
         * Uma forma de resolver este problema é serializanso os dados retonados a transformalos em json.
         * Assim a manipulacao via json fica mais simples, para a manipulacao da infomacao.
         */
        $build = SerializerBuilder::create()->build()->serialize($beers, 'json');

        return $this->returnResponse($build, 200);
    }

    public function createBeer(Request $request)
    {
        $orm = $this->app['orm.em'];

        $data = $request->request->all();

        $createdAt = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));
        $updatedAt = new \DateTime("now", new \DateTimeZone("America/Sao_Paulo"));

        $beer = new Beer();

        $beer->setName($data['name'])
             ->setPrice($data['price'])
             ->setType($data['type'])
             ->setMark($data['mark'])
             ->setCreatedAt($createdAt)
             ->setUpdatedAt($updatedAt);

        $orm->persist($beer);
        $orm->flush();

        return $this->returnResponse(json_encode(['msg'=>'beer saved sucessfull']),200);
    }
    
}
