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
     * @param string $unitId
     * @param string $timestamp
     *
     * @return array
     */
    public function fetchDownloadMetrics(string $unitId, string $timestamp)
    {
        return $this->fetchMetrics(self::DOWNLOAD_TABLE, $unitId, $timestamp);
    }

    /**
     * @param string $unitId
     * @param string $timestamp
     *
     * @return array
     */
    public function fetchUploadMetrics(string $unitId, string $timestamp)
    {
        return $this->fetchMetrics(self::UPLOAD_TABLE, $unitId, $timestamp);
    }

    /**
     * @param string $unitId
     * @param string $timestamp
     *
     * @return array
     */
    public function fetchLatencyMetrics(string $unitId, string $timestamp)
    {
        return $this->fetchMetrics(self::LATENCY_TABLE, $unitId, $timestamp);
    }

    /**
     * @param string $unitId
     * @param string $timestamp
     *
     * @return array
     */
    public function fetchPacketLOssMetrics(string $unitId, string $timestamp)
    {
        return $this->fetchMetrics(self::PACKET_LOSS_TABLE, $unitId, $timestamp);
    }

    /**
     * @param string $tableName
     * @param string $unitId
     * @param string $timestamp
     *
     * @return array
     */
    private function fetchMetrics(string $tableName, string $unitId, string $timestamp)
    {
        try {
            $query = $this->queryBuilder
                ->select('*')
                ->from($tableName)
                ->where('unit_id = :unitId')
                ->setParameter('unitId', $unitId);

            if (!empty($timestamp)) {
                $query->andWhere('timestamp = :timestamp')
                    ->setParameter('timestamp', $timestamp);
            }

            return $query->execute()->fetchAll();

        } catch(\Exception $e) {
            // ignore for now
        }
    }
}
