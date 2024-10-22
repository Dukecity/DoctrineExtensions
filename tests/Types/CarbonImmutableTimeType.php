<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\CarbonImmutable;
use Carbon\Doctrine\CarbonDoctrineType;
use Carbon\Doctrine\CarbonTypeConverter;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\TimeImmutableType;

class CarbonImmutableTimeType extends TimeImmutableType implements CarbonDoctrineType
{
    use CarbonTypeConverter {
        convertToDatabaseValue as convertCarbonToDatabaseValue;
    }

    public const CARBONTIME_IMMUTABLE = 'carbontime_immutable';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $this->convertCarbonToDatabaseValue($value, $platform);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @throws ValueNotConvertible
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTimeImmutable
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
