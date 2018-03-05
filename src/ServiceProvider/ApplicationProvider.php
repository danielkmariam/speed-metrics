<?php
namespace ServiceProvider;

use ApiClient\ClientInterface;
use ApiClient\DataPointService;
use ApiClient\GuzzleClient;
use Calculator\MetricsCalculator;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Doctrine\DBAL\Query\QueryBuilder;
use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Repository\MetricsRepository;
use Response\AggregateJson;

/**
 * Class ApplicationProvider
 */
class ApplicationProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(PimpleContainer $container)
    {
        $container[ClientInterface::class] = function(): GuzzleClient {
            return new GuzzleClient();
        };

        $container[AggregateJson::class] = function($container): AggregateJson {
            return new AggregateJson(
                $container[DataPointService::class],
                $container[MetricsRepository::class]
            );
        };

        $container[Driver::class] = function(): AbstractMySQLDriver  {
            return new Driver\PDOMySql\Driver();
        };

        $container[Configuration::class] = function (): Configuration {
            return new Configuration();
        };

        $container[MetricsCalculator::class] = function ($container): MetricsCalculator {
            return new MetricsCalculator($container[MetricsRepository::class]);
        };

        $container[DataPointService::class] = function ($container): DataPointService {
            return new DataPointService(
                $container[ClientInterface::class],
                'http://tech-test.sandbox.samknows.com/php-2.0/testdata.json'
            );
        };

        $container[MetricsRepository::class] = function ($container): MetricsRepository {
            return new MetricsRepository($container[QueryBuilder::class]);
        };
    }
}
