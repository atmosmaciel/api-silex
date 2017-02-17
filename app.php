<?php

require "bootstrap.php";

use Silex\Application;

use Api\Service\RouterServiceProvider;
use Api\Service\ControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\ServiceControllerServiceProvider;

$app = new Application();

$app['debug'] = true;

$app['api_version'] = '/v1';

$app->after(function (Request $request, Response $response){
    $response->headers->set('Content-Type', 'application/json');
});

$app->register(new RouterServiceProvider());
$app->register(new ControllerServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app->register(new \Silex\Provider\DoctrineServiceProvider(), array(
    'dbs.options' => array(
        'default' => $dbParams
    )
));
$app->register(new \Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => '/tmp',
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'use_simple_annotation_reader' => false,
                'namespace' => 'Api\Model',
                'path' => __DIR__ . '/src'
            ),
        ),
    ),
    'orm.proxies_namespace' => 'EntityProxy',
    'orm.auto_generate_proxies' => true,
    'orm.default_cache' => 'array'
));
