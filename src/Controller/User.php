<?php

namespace Api\Controller;

use Illuminate\Hashing\BcryptHasher;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Api\Service\ValidateValues;

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

        $validation = new ValidateValues();

        $name = $validation->validateName($data['name']);
        $celPhone = $validation->validateCelphone($data['celphone']);
        $email = $validation->validateEmail($data['email']);
        $website = $validation->validateWebsite($data['website']);

        $password = new BcryptHasher();
        $password = $password->make($data['password']);

        $user->setName($name)
             ->setCelphone($celPhone)
             ->setEmail($email)
             ->setWebsite($website)
             ->setPassword($password)
             ->setCreatedAt($this->getDateTimeNow())
             ->setUpdatedAt($this->getDateTimeNow());

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

        foreach ($data as $key=>$value) {
            $set = "set" . ucfirst($key);

            if ($set == "setPassword") {
                $password = new BcryptHasher();
                $password = $password->make($data['password']);
                $user->setPassword($password);
            } else {
                $user->$set($value);
            }
        }

        $user->setUpdatedAt($this->getDateTimeNow());

        $orm->merge($user);
        $orm->flush();

        return json_encode(["msg"=>"beer sucessfull updatad at"]);
    }

    public function delete($id = null)
    {
        if (!isset($id) || is_null($id)){
            return json_encode(["msg" => "ID nao informado"]);
        }

        $orm = $this->getDoctrineService();

        $user = $orm->getRepository('Api\Model\User')
                    ->find($id);

        $orm->remove($user);
        $orm->flush();

        return json_encode(["msg"=>"beer sucessfull deleted at"]);
    }
}
