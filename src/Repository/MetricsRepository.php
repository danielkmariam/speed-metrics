<?php

namespace Repository;

use Doctrine\DBAL\Query\QueryBuilder;

class MetricsRepository
{
    const DOWNLOAD_TABLE = 'download';
    const UPLOAD_TABLE = 'upload';
    const LATENCY_TABLE = 'latency';
    const PACKET_LOSS_TABLE = 'packet_loss';

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @param QueryBuilder $queryBuilder
     */
    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param string $tableName
     * @param array  $values
     */
    public function persist(string $tableName, array $values)
    {
        try {
            $this->queryBuilder
                ->insert($tableName)
                ->values($values)
                ->execute();
        } catch(\Exception $e) {
            // ignore for now
        }
    }

    /**
     * @param string $tableName
     * @param string $unitId
     * @param string $hour
     *
     * @return mixed
     */
    public function fetchHourlyMaxMetrics(string $tableName, string $unitId, string $hour)
    {
        $query = $this->queryBuilder
            ->select('max(value) as value')
            ->from($tableName)
            ->where('unit_id = :unitId')
            ->andWhere('HOUR(timestamp) = :time')
            ->setParameter('unitId', $unitId)
            ->setParameter('time', $hour);

        return $query->execute()->fetch()['value'];
    }

    /**
     * @param string $tableName
     * @param string $unitId
     * @param string $hour
     *
     * @return mixed
     */
    public function fetchHourlyMinMetrics(string $tableName, string $unitId, string $hour)
    {
        $query = $this->queryBuilder
            ->select('min(value) as value')
            ->from($tableName)
            ->where('unit_id = :unitId')
            ->andWhere('HOUR(timestamp) = :time')
            ->setParameter('unitId', $unitId)
            ->setParameter('time', $hour);

        return $query->execute()->fetch()['value'];
    }

    /**
     * @param string $tableName
     * @param string $unitId
     * @param string $hour
     *
     * @return mixed
     */
    public function fetchHourlyMeanMetrics(string $tableName, string $unitId, string $hour)
    {
        $query = $this->queryBuilder
            ->select('avg(value) as value')
            ->from($tableName)
            ->where('unit_id = :unitId')
            ->andWhere('HOUR(timestamp) = :time')
            ->setParameter('unitId', $unitId)
            ->setParameter('time', $hour);

        return $query->execute()->fetch()['value'];
    }

    /**
     * @param string $tableName
     * @param string $unitId
     * @param string $hour
     *
     * @return mixed
     */
    public function fetchHourlyMetrics(string $tableName, string $unitId, string $hour)
    {
        $query = $this->queryBuilder
            ->select('value')
            ->from($tableName)
            ->where('unit_id = :unitId')
            ->andWhere('HOUR(timestamp) = :time')
            ->addOrderBy('value')
            ->setParameter('unitId', $unitId)
            ->setParameter('time', $hour);

        return array_map(function($row) {
            return $row['value'];
        }, $query->execute()->fetchAll());
    }

    /**
     * @return mixed
     */
    public function fetchSampleSize()
    {
        $query = $this->queryBuilder
            ->select('count(DISTINCT unit_id) as value')
            ->from('download');

        return $query->execute()->fetch()['value'];
    }

    /**
     * @param string $metrics
     * @param string $unitId
     * @param string $timestamp
     *
     * @return array
     */
    public function fetchMetrics(string $metrics, string $unitId, string $timestamp)
    {
        if (!$this->isValidMetrics($metrics)) {
            return [];
        }

        $query = $this->queryBuilder
            ->select('*')
            ->from($metrics)
            ->where('unit_id = :unitId')
            ->andWhere('timestamp = :timestamp')
            ->setParameter('unitId', $unitId)
            ->setParameter('timestamp', $timestamp);

        return $query->execute()->fetchAll();
    }

    /**
     * @param $metrics
     *
     * @return bool
     */
    private function isValidMetrics($metrics)
    {
        return in_array($metrics, [
            self::DOWNLOAD_TABLE,
            self::UPLOAD_TABLE,
            self::LATENCY_TABLE,
            self::PACKET_LOSS_TABLE
        ]);
    }
}
