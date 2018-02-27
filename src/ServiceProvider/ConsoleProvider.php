<?php
namespace ServiceProvider;

use ApiClient\DataPointService;
use Command\AggregateData;
use Command\UnitMetrics;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Repository\MetricsRepository;
use Response\AggregateJson;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        $container[InputInterface::class] = function (): ArgvInput {
            return new ArgvInput();
        };

        $container[OutputInterface::class] = function (): ConsoleOutput {
            return new ConsoleOutput();
        };

        $container[AggregateData::class] = function ($container): AggregateData {
            return new AggregateData($container[AggregateJson::class]);
        };

        $container[UnitMetrics::class] = function ($container): UnitMetrics {
            return new UnitMetrics($container[MetricsRepository::class]);
        };

        $container[Application::class] = function ($container): Application {
            $application = new Application();
            $application->add($container[AggregateData::class]);
            $application->add($container[UnitMetrics::class]);

            return $application;
        };

        $container[QueryBuilder::class] = function(): QueryBuilder {
            return new QueryBuilder(
                DriverManager::getConnection([
                    'user' => 'root',
                    'password' => 'root',
                    'host' => 'localhost',
                    'dbname' => 'speed_metrics',
                    'driver' => 'pdo_mysql',
                    'port' => 3306,
                ], new Configuration())
            );
        };
        $container[Connection::class] = function ($container): Connection {
            return new Connection([
                    'user' => 'root',
                    'password' => 'root',
                    'host' => 'localhost',
                    'dbname' => 'speed_metrics',
                    'driver' => 'pdo_mysql',
                    'port' => 3306,
                ],
                $container[Driver::class],
                $container[Configuration::class]
            );
        };
    }
}
