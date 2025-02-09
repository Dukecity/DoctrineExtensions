<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class InetAtonTest extends MysqlTestCase
{
    public function testInetAton(): void
    {
        $this->assertDqlProducesSql(
            "SELECT INET_ATON('127.0.0.1') FROM DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT INET_ATON('127.0.0.1') AS sclr_0 FROM Blank b0_"
        );
    }
}
