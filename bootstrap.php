<?php

require 'vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

$isDevMode = false;

$paths = array(__DIR__ . '/src/Model');

$dbParams = array(
     'driver'   => 'pdo_pgsql'
    ,'host'     => 'localhost'
    ,'port'     => '5432'
    ,'user'     => 'postgres'
    ,'password' => '#clare47*#'
    ,'dbname'   => 'api_silex'
    ,'charset'  => 'UTF8'
);

$config = Setup::createConfiguration($isDevMode);

$driver = new AnnotationDriver(new AnnotationReader(), $paths);

$config->setMetadataDriverImpl($driver);

AnnotationRegistry::registerFile(
    __DIR__ . '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
);

$entityManager = EntityManager::create($dbParams, $config);
