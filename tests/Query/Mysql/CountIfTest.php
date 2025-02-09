<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class CountIfTest extends MysqlTestCase
{
    public function testCountIf(): void
    {
        $this->assertDqlProducesSql(
            "SELECT COUNTIF(2, 3) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT COUNT(CASE 2 WHEN 3 THEN 1 ELSE NULL END) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testCountIfInverse(): void
    {
        $this->assertDqlProducesSql(
            "SELECT COUNTIF(2, 3 INVERSE) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT COUNT(CASE 2 WHEN 3 THEN NULL ELSE 1 END) AS sclr_0 FROM Blank b0_'
        );
    }
}
