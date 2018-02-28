<?php

namespace Command;

use Repository\MetricsRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MeanHourly
 */
class MeanHourly extends Command
{
    /**
     * @var MetricsRepository
     */
    private $repository;

    /**
     * @param MetricsRepository $repository
     */
    public function __construct(MetricsRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("hourly:mean")
            ->setDescription("Hourly mean reading for a given unit and metrics")
            ->addArgument('unit_id', InputArgument::REQUIRED, 'Id of the unit to check')
            ->addArgument('metrics', InputArgument::REQUIRED, 'Type of metrics to check. The options are download, upload ')
            ->addArgument('time', InputArgument::REQUIRED, 'Hour to check the metrics in `am` and `pm` format');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $unitId = $input->getArgument('unit_id');
        $metrics = $input->getArgument('metrics');

        $output->writeln(sprintf(
            "Unit #%s's mean %s at %s > %s",
            $unitId,
            $metrics,
            $input->getArgument('time'),
            $this->repository->fetchHourlyMeanMetrics($metrics, $unitId, $this->changeAmPmTo24Hr($input))
        ));
    }

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function changeAmPmTo24Hr(InputInterface $input)
    {
        return DATE("G", STRTOTIME($input->getArgument('time'))) + 1;
    }
}
