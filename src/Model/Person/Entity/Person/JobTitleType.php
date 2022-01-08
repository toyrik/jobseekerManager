<?php

namespace App\Model\Person\Entity\Person;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class JobTitleType extends StringType
{
    public const NAME = 'job_title';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof JobTitle ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new JobTitle($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
