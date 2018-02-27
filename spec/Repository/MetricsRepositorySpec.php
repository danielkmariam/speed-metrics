<?php

namespace spec\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use PhpSpec\ObjectBehavior;

class MetricsRepositorySpec extends ObjectBehavior
{
    function let(QueryBuilder $queryBuilder)
    {
        $this->beConstructedWith($queryBuilder);
    }

    function it_should_persist_data(QueryBuilder $queryBuilder)
    {
        $tableName = 'download';
        $values = [
            'unit_id' => 1,
            'timestamp' => '2017-02-27 08:00:00',
            'value' => 12345
        ];

        $queryBuilder->insert($tableName)->willReturn($queryBuilder);
        $queryBuilder->values($values)->willReturn($queryBuilder);
        $queryBuilder->execute()->willReturn($queryBuilder);

        $this->persist($tableName, $values);
    }
}
