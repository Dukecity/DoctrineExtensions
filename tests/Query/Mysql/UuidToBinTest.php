<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class UuidToBinTest extends MysqlTestCase
{
    public function testUuidToBin(): void
    {
        $this->assertDqlProducesSql(
            "SELECT UUID_TO_BIN(b.id) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT UUID_TO_BIN(b0_.id) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testBinToUuidSwapFlag(): void
    {
        $this->assertDqlProducesSql(
            "SELECT BIN_TO_UUID(b.id, 1) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT BIN_TO_UUID(b0_.id, 1) AS sclr_0 FROM Blank b0_'
        );
    }
}
