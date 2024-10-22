<?php

namespace DoctrineExtensions\Tests\Types;

use Carbon\Doctrine\CarbonType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class CarbonDateTimeType extends CarbonType
{
    public const CARBONDATETIME = 'carbondatetime';

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
