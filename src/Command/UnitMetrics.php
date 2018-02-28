<?php

namespace Command;

use DateTime;
use Repository\MetricsRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->setDescription("Unit metrics")
            ->addArgument('unit_id', InputArgument::REQUIRED, 'Id of the unit to check')
            ->addArgument('metrics', InputArgument::OPTIONAL, 'Type of metrics to check. The options are download, upload ')
            ->addArgument('date', InputArgument::OPTIONAL, 'Date to check the metrics in `2017-02-01` format')
            ->addArgument('time', InputArgument::OPTIONAL, 'Hour to check the metrics in `am` and `pm` format');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $unitId = $input->getArgument('unit_id');
        $metrics = $input->getArgument('metrics');

        $metricsResult = [];
        if ($metrics == MetricsRepository::DOWNLOAD_TABLE) {
            $metricsResult = $this->repository->fetchDownloadMetrics($unitId, $this->getTimeStamp($input));
        }

        if ($metrics == MetricsRepository::UPLOAD_TABLE) {
            $metricsResult = $this->repository->fetchUploadMetrics($unitId, $this->getTimeStamp($input));
        }

        if ($metrics == MetricsRepository::LATENCY_TABLE) {
            $metricsResult = $this->repository->fetchLatencyMetrics($unitId, $this->getTimeStamp($input));
        }

        if ($metrics == MetricsRepository::PACKET_LOSS_TABLE) {
            $metricsResult = $this->repository->fetchPacketLossMetrics($unitId, $this->getTimeStamp($input));
        }

        foreach ($metricsResult as $metric) {
            $output->write(sprintf('%s,%s', $metric['unit_id'], $metric['value']).PHP_EOL);
        }
    }

    /**
     * @param InputInterface $input
     *
     * @return mixed
     */
    protected function getTimeStamp(InputInterface $input)
    {
        $date = $input->getArgument('date');
        $time = $input->getArgument('time');

        $timestamp = null;
        if (isset($time) && isset($time)) {
            $timestamp = new DateTime(sprintf('%s %s', $date, DATE("H:i", STRTOTIME($time))));
        }

        return !is_null($timestamp) ? $timestamp->format('Y-m-d H:s:i'): '';
    }
}
