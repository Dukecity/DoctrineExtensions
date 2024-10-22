<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon;
use Carbon\Doctrine\CarbonDoctrineType;
use Carbon\Doctrine\CarbonTypeConverter;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;

class CarbonDateTimeTzType extends DateTimeTzType implements CarbonDoctrineType
{
    /** @use CarbonTypeConverter<Carbon> */
    use CarbonTypeConverter {
        convertToDatabaseValue as convertCarbonToDatabaseValue;
    }

    public const CARBONDATETIMETZ = 'carbondatetimetz';

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
