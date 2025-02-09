<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class HourTest extends MysqlTestCase
{
    public function testHour():void
    {
        $this->assertDqlProducesSql(
            "SELECT HOUR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT HOUR(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
