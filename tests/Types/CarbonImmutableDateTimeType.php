<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Doctrine\DateTimeImmutableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class CarbonImmutableDateTimeType extends DateTimeImmutableType
{
    public const CARBONDATETIME_IMMUTABLE = 'carbondatetime_immutable';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
