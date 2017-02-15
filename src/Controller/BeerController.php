<?php

namespace Api\Controller;

use Api\Model\Beer;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;

class BeerController extends BaseController
{
    public function get($id = null)
    {
        $beers = $this->getDoctrineService()
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

    public function create(Request $request)
    {
        $orm = $this->getDoctrineService();

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

    public function update(Request $request)
    {
        $data = $request->request->all();

        if (!isset($data['id'])) {
            return $this->returnResponse(json_encode(["msg" => "ID não informado"]), 401);
        }

        $orm = $this->getDoctrineService();

        $beer = $orm->getRepository('Api\Model\Beer')
                    ->find($data['id']);

        if (isset($data['name'])) {
            $beer->setName($data['name']);
        }

        if (isset($data['price'])) {
            $beer->setPrice($data['price']);
        }

        if (isset($data['type'])) {
            $beer->setType($data['type']);
        }

        if (isset($data['mark'])) {
            $beer->setType($data['mark']);
        }

        $beer->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

        $orm->merge($beer);
        $orm->flush();

        return $this->returnResponse(json_encode(["msg"=>"beer sucessfull updatad at"]),200);
    }

    public function delete(Request $request)
    {
        $data = $request->request->all();

        if (!isset($data['id']) || is_null($data['id'])){
            return $this->returnResponse(json_encode(["msg" => "ID não informado"]), 401);
        }

        $orm = $this->getDoctrineService();

        $beer = $orm->getRepository('Api\Model\Beer')
            ->find($data['id']);

        $orm->remove($beer);
        $orm->flush();

        return $this->returnResponse(json_encode(["msg"=>"beer sucessfull deleted at"]),200);
    }
}
