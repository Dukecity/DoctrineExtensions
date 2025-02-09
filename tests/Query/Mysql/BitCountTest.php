<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class BitCountTest extends MysqlTestCase
{
    public function testBitCount(): void
    {
        $this->assertDqlProducesSql(
            "SELECT BIT_COUNT(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT BIT_COUNT(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
