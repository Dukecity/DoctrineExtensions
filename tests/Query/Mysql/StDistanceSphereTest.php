<?php

namespace DoctrineExtensions\Tests\Query\Mysql;

use DoctrineExtensions\Tests\Query\MysqlTestCase;

final class StDistanceSphereTest extends MysqlTestCase
{
    public function testStDistanceSphere(): void
    {
        $this->assertDqlProducesSql(
            "SELECT ST_DISTANCE_SPHERE(1, 2) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ST_DISTANCE_SPHERE(1, 2) AS sclr_0 FROM Blank b0_'
        );
    }

    public function testStDistanceSphereWithExpression(): void
    {
        $this->assertDqlProducesSql(
            "SELECT ST_DISTANCE_SPHERE(POINT(1 2), POINT(3 4)) from DoctrineExtensions\Tests\Entities\Blank b",
            'SELECT ST_DISTANCE_SPHERE(POINT(1 2), POINT(3 4)) AS sclr_0 FROM Blank b0_'
        );
    }
}
