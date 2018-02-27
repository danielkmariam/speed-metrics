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
}
