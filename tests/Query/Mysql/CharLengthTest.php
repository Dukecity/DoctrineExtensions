<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class CharLengthTest extends MysqlTestCase
{
    public function testCharLength(): void
    {
        $this->assertDqlProducesSql(
            "SELECT CHAR_LENGTH(2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT CHAR_LENGTH(2) AS sclr_0 FROM Blank b0_'
        );
    }
}
