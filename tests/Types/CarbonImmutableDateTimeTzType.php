<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\Doctrine\CarbonDoctrineType;
use Carbon\Doctrine\CarbonTypeConverter;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeTzImmutableType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;

class CarbonImmutableDateTimeTzType extends DateTimeTzImmutableType implements CarbonDoctrineType
{
    /** @use CarbonTypeConverter<Carbon> */
    use CarbonTypeConverter {
        convertToDatabaseValue as convertCarbonToDatabaseValue;
    }

    public const CARBONDATETIMETZ_IMMUTABLE = 'carbondatetimetz_immutable';

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        return $this->convertCarbonToDatabaseValue($value, $platform);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ValueNotConvertible
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?CarbonImmutable
    {
        return $this->doConvertToPHPValue($value);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    protected function getClassName(): string
    {
        return CarbonImmutable::class;
    }
}
