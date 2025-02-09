<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class DateFormatTest extends MysqlTestCase
{
    public function testDateFormat(): void
    {
        $this->assertDqlProducesSql(
            "SELECT DATE_FORMAT(2, 'Y') from DoctrineExtensions\Tests\Entities\Blank b",
            "SELECT DATE_FORMAT(2, 'Y') AS sclr_0 FROM Blank b0_"
        );
    }
}
