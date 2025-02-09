<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class VarianceTest extends MysqlTestCase
{
    public function testVariance(): void
    {
        $this->assertDqlProducesSql(
            "SELECT VARIANCE(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT VARIANCE(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
