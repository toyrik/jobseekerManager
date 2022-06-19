<?php

namespace App\Twig\Extension\Processor;

use App\Twig\Extension\Processor\Driver\Driver;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Webmozart\Assert\Assert;

class ProcessorExtension extends AbstractExtension
{
    /**
     * @var Driver[]
     */
    private $drivers;

    public function __construct(array $drivers)
    {
        Assert::allIsInstanceOf($drivers, Driver::class);
        $this->drivers = $drivers;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('vacancy_processor', [$this, 'process'], ['is_safe' => ['html']]),
        ];
    }

    public function process(?string $text): string
    {
        $result = $text;
        foreach ($this->drivers as $driver) {
            $result = $driver->process($result);
        }
        return $result;
    }
}
