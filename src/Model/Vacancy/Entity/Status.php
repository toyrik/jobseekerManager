<?php

namespace App\Model\Vacancy\Entity;

use Webmozart\Assert\Assert;

class Status
{
    public const NEW = 'new';
    public const ACTIVE = 'active';
    public const ARCHIVE = 'archive';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name,[
            self::NEW,
            self::ACTIVE,
            self::ARCHIVE,
        ]);

        $this->name = $name;
    }

    public static function new(): self
    {
        return new self(self::NEW);
    }

    public static function active(): self
    {
        return new self(self::ACTIVE);
    }

    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName():string
    {
        return $this->name;
    }

    public function isNew(): bool
    {
        return $this->name === self::NEW;
    }
}
