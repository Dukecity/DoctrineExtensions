<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon;
use Carbon\Doctrine\CarbonDoctrineType;
use Carbon\Doctrine\CarbonTypeConverter;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\TimeType;

class CarbonTimeType extends TimeType implements CarbonDoctrineType
{
    use CarbonTypeConverter {
        convertToDatabaseValue as convertCarbonToDatabaseValue;
    }

    public const CARBONTIME = 'carbontime';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $this->convertCarbonToDatabaseValue($value, $platform);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ValueNotConvertible
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTime
    {
        return $this->doConvertToPHPValue($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    protected function getClassName(): string
    {
        return Carbon::class;
    }
}
