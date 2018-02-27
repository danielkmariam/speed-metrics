<?php
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Component\Console\Application;

$container = new Pimple\Container;;

$container['service.dbal_query_builder'] = function() {
    $params = [
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'dbname' => 'speed_metrics',
        'driver' => 'pdo_mysql',
        'port' => 3306,
    ];
    return new QueryBuilder(
        DriverManager::getConnection($params, new Configuration())
    );
};


$container['application'] = function (): Application {
    $application = new Application();
    return $application;
};

return $container;
