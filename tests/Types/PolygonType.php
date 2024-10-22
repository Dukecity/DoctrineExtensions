<?php

namespace DoctrineExtensions\Tests\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class PolygonType extends Type
{
    public const FIELD = 'polygon';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'POLYGON';
    }

    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        preg_match('/POLYGON\(\((.*)\)\)/', $value, $matches);
        if (!isset($matches[1])) {
            throw new \Exception('No Polygon Points');
        }

        return $matches[1];
    }

    public function convertToPHPValueSQL($sqlExpr, $platform): string
    {
        return sprintf('AsText(%s)', $sqlExpr);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return sprintf('POLYGON((%s))', $value);
    }

    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('ST_PolygonFromText(%s)', $sqlExpr);
    }

    public function getName(): string
    {
        return self::FIELD;
    }
}
