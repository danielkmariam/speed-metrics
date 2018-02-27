<?php

namespace Repository;

use Doctrine\DBAL\Query\QueryBuilder;

class MetricsRepository
{
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
