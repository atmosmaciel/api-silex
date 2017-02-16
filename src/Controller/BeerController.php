<?php

namespace Api\Controller;

use Api\Model\Beer;
use Silex\Application;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;

class BeerController extends BaseController
{
    private $beer;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->beer = new Beer();
    }

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

        $build = SerializerBuilder::create()->build()->serialize($beers, 'json');

        return $build;
    }

    public function create(Request $request)
    {
        $data = $request->request->all();

        $this->beer->setName($data['name'])
                   ->setPrice($data['price'])
                   ->setType($data['type'])
                   ->setMark($data['mark'])
                   ->setCreatedAt($this->getHourCreate())
                   ->setUpdatedAt($this->getHourUpdate());

        $orm = $this->getDoctrineService();
        $orm->persist($this->beer);
        $orm->flush();

        return json_encode(['msg'=>'beer saved sucessfull']);
    }

    public function update(Request $request)
    {
        $data = $request->request->all();

        if (!isset($data['id']) || is_null($data['id'])){
            return json_encode(["msg" => "ID nao informado"]);
        }

        $orm = $this->getDoctrineService();

        $beer = $orm->getRepository('Api\Model\Beer')
                    ->find($data['id']);

        foreach ($data as $key=>$value){
            $set = "set".ucfirst($key);
            $beer->$set($value);
        }

        $beer->setUpdatedAt($this->getHourUpdate());

        $orm->merge($beer);
        $orm->flush();

        return json_encode(["msg"=>"beer sucessfull updatad at"]);
    }

    public function delete(Request $request)
    {
        $data = $request->request->all();

        if (!isset($data['id']) || is_null($data['id'])){
            return json_encode(["msg" => "ID nao informado"]);
        }

        $orm = $this->getDoctrineService();

        $beer = $orm->getRepository('Api\Model\Beer')
            ->find($data['id']);

        $orm->remove($beer);
        $orm->flush();

        return json_encode(["msg"=>"beer sucessfull deleted at"]);
    }
}
