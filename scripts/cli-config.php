<?php

$classLoader = new \Doctrine\Common\ClassLoader('Entities', __DIR__);
$classLoader->register();

$classLoader = new \Doctrine\Common\ClassLoader('Proxies', __DIR__);
$classLoader->register();

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());

$driverImpl = new Doctrine\ORM\Mapping\Driver\XmlDriver(
    __DIR__ . "/../data/xml/"
);

$config->setMetadataDriverImpl($driverImpl);

$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');

$connection = array(
    'driver' => 'pdo_sqlite',
    'path' => 'database.sqlite'
);

$em = \Doctrine\ORM\EntityManager::create($connection, $config);

$helpers = new \Symfony\Components\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));