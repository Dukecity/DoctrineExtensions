<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class DivTest extends MysqlTestCase
{
    public function testDiv():void
    {
        $this->assertDqlProducesSql(
            "SELECT DIV(2, 5) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT 2 DIV 5 AS sclr_0 FROM Blank b0_'
        );
    }
}
