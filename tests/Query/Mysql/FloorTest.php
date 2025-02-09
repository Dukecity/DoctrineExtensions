<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class FloorTest extends MysqlTestCase
{
    public function testFloor():void
    {
        $this->assertDqlProducesSql(
            "SELECT FLOOR(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT FLOOR(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
