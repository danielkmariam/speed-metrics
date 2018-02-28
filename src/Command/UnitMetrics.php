<?php

namespace Command;

use DateTime;
use Repository\MetricsRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class UnitMetrics
 */
class UnitMetrics extends Command
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
        $this->setName("unit:metrics")
            ->setDescription("Read unit metrics for a give day and time")
            ->addArgument('unit_id', InputArgument::REQUIRED, 'Id of the unit to check')
            ->addArgument('metrics', InputArgument::REQUIRED, 'Type of metrics to check. The options are download, upload ')
            ->addArgument('date', InputArgument::REQUIRED, 'Date to check the metrics in `2017-02-01` format')
            ->addArgument('time', InputArgument::REQUIRED, 'Hour to check the metrics in `am` and `pm` format');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $unitId = $input->getArgument('unit_id');
        $metrics = $input->getArgument('metrics');
        $metricsResult = $this->repository->fetchMetrics($metrics, $unitId, $this->getTimeStamp($input));

        if (count($metricsResult) == 0) {
            $output->writeln(sprintf(
                "Unit #%s's %s on %s at %s > No reading found",
                $unitId,
                $metrics,
                $input->getArgument('date'),
                $input->getArgument('time')
            ));
        } else {
            $output->writeln(sprintf(
                "Unit #%s's %s on %s at %s > %s",
                $unitId,
                $metrics,
                $input->getArgument('date'),
                $input->getArgument('time'),
                $metricsResult[0]['value']
            ));
        }
    }

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function getTimeStamp(InputInterface $input)
    {
        $timestamp = new DateTime(sprintf(
            '%s %s',
            $input->getArgument('date'),
            DATE("H:i", STRTOTIME($input->getArgument('time')))
        ));

        return $timestamp->format('Y-m-d H:s:i');
    }
}
