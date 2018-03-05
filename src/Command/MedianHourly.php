<?php

namespace Command;

use Calculator\MetricsCalculator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class MedianHourly
 */
class MedianHourly extends Command
{
    /**
     * @var MetricsCalculator
     */
    private $calculator;

    /**
     * @param MetricsCalculator $calculator
     *
     * @internal param MetricsRepository $repository
     */
    public function __construct(MetricsCalculator $calculator)
    {
        parent::__construct();
        $this->calculator = $calculator;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("hourly:median")
            ->setDescription("Hourly median reading for a given unit and metrics")
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
            "Unit #%s's median %s at %s > %s",
            $unitId,
            $metrics,
            $input->getArgument('time'),
            $this->calculator->calculateMedian($metrics, $unitId, $this->changeAmPmTo24Hr($input))
        ));
    }

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function changeAmPmTo24Hr(InputInterface $input)
    {
        return DATE("G", STRTOTIME($input->getArgument('time')));
    }
}
