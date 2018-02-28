<?php

namespace Calculator;

use Repository\MetricsRepository;

final class MetricsCalculator
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
        $this->repository = $repository;
    }

    /**
     * @param string $tableName
     * @param string $unitId
     * @param string $timestamp
     *
     * @return float|int
     */
    public function calculateMedian(string $tableName, string $unitId, string $timestamp)
    {
        $data = $this->repository->fetchHourlyMedianMetrics($tableName, $unitId, $timestamp);
        if (empty($data)) {
            return 0;
        }

        $numberOfReadings = count($data);
        $middleKey = (int)($numberOfReadings/2);

        if ($numberOfReadings % 2) {
            return $data[$middleKey];
        }
        return ($data[$middleKey] + $data[$middleKey - 1]) / 2;
    }
}
