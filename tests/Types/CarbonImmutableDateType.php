<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Doctrine\CarbonImmutableType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class CarbonImmutableDateType extends CarbonImmutableType
{
    public const CARBONDATE_IMMUTABLE = 'carbondate_immutable';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
