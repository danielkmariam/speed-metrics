<?php
namespace Command;

use ApiClient\DataPointService;
use Repository\MetricsRepository;
use Response\AggregateJson;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ParseResponse
 */
class AggregateData extends Command
{
    /**
     * @var AggregateJson
     */
    private $aggregateJson;

    /**
     * @param AggregateJson $aggregateJson
     */
    public function __construct(AggregateJson $aggregateJson)
    {
        parent::__construct();
        $this->aggregateJson = $aggregateJson;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("aggregate:data")
            ->setDescription("Aggregate data and store to database.");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('>Started aggregating remote data');

        $this->aggregateJson->aggregate();

        $output->writeln('>All done you can now check the stats');
    }
}
