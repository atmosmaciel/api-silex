<?php

namespace Api\Controller;

use Illuminate\Hashing\BcryptHasher;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;

class User extends Base
{
    public function get($id = null)
    {
        $users = $this->getDoctrineService()
                      ->getRepository('Api\Model\User');

        if (is_null($id)){
            $users = $users->findAll();
        } else {
            $id = (int) $id;
            $users = $users->find($id);
        }

        $build = SerializerBuilder::create()->build()->serialize($users, 'json');

        return $build;
    }

    public function create(Request $request)
    {
        $data = $request->request->all();

        $user = new \Api\Model\User();

        $password = new BcryptHasher();
        $password = $password->make($data['password']);

        $user->setName($data['name'])
             ->setCelphone($data['celphone'])
             ->setEmail($data['email'])
             ->setWebsite($data['website'])
             ->setPassword($password)
             ->setCreatedAt($this->getHourCreate())
             ->setUpdatedAt($this->getHourUpdate());

        $orm = $this->getDoctrineService();
        $orm->persist($user);
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

        $user = $orm->getRepository('Api\Model\User')
                    ->find($data['id']);

        foreach ($data as $key=>$value){
            $set = "set" . ucfirst($key);
            if (!$set === "setPassword"){
                $user->$set($value);
            }

            $password = new BcryptHasher();
            $password = $password->make($data['password']);
            $user->setPassword($password);
        }

        $user->setUpdatedAt($this->getHourUpdate());

        $orm->merge($user);
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

        $user = $orm->getRepository('Api\Model\User')
                    ->find($data['id']);

        $orm->remove($user);
        $orm->flush();

        return json_encode(["msg"=>"beer sucessfull deleted at"]);
    }
}
