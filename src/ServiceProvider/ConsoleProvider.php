<?php
namespace ServiceProvider;

use ApiClient\DataPointService;
use Command\AggregateData;
use Command\MaximumHourly;
use Command\MeanHourly;
use Command\MedianHourly;
use Command\MinimumHourly;
use Command\SampleSize;
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
        $container[AggregateData::class] = function ($container): AggregateData {
            return new AggregateData($container[AggregateJson::class]);
        };

        $container[UnitMetrics::class] = function ($container): UnitMetrics {
            return new UnitMetrics($container[MetricsRepository::class]);
        };

        $container[MaximumHourly::class] = function ($container): MaximumHourly {
            return new MaximumHourly($container[MetricsRepository::class]);
        };

        $container[MinimumHourly::class] = function ($container): MinimumHourly {
            return new MinimumHourly($container[MetricsRepository::class]);
        };

        $container[MedianHourly::class] = function ($container): MedianHourly {
            return new MedianHourly($container[MetricsRepository::class]);
        };

        $container[MeanHourly::class] = function ($container): MeanHourly {
            return new MeanHourly($container[MetricsRepository::class]);
        };

        $container[SampleSize::class] = function ($container): SampleSize {
            return new SampleSize($container[MetricsRepository::class]);
        };

        $container[Application::class] = function ($container): Application {
            $application = new Application();
            $application->add($container[AggregateData::class]);
            $application->add($container[UnitMetrics::class]);
            $application->add($container[MinimumHourly::class]);
            $application->add($container[MaximumHourly::class]);
            $application->add($container[MeanHourly::class]);
            $application->add($container[MedianHourly::class]);
            $application->add($container[SampleSize::class]);

            return $application;
        };

        $container[QueryBuilder::class] = function($container): QueryBuilder {
            return new QueryBuilder(
                DriverManager::getConnection([
                    'user' => 'root',
                    'password' => 'root',
                    'host' => 'localhost',
                    'dbname' => 'speed_metrics',
                    'driver' => 'pdo_mysql',
                    'port' => 3306,
                ], $container[Configuration::class])
            );
        };
    }
}
