<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon;
use Carbon\Doctrine\CarbonDoctrineType;
use Carbon\Doctrine\CarbonTypeConverter;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;

class CarbonDateType extends DateType implements CarbonDoctrineType
{
    /** @use CarbonTypeConverter<Carbon> */
    use CarbonTypeConverter {
        convertToDatabaseValue as convertCarbonToDatabaseValue;
    }

    public const CARBONDATE = 'carbondate';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $this->convertCarbonToDatabaseValue($value, $platform);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ValueNotConvertible
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Carbon
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
