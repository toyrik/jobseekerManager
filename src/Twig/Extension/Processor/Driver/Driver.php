<?php

namespace App\Twig\Extension\Processor\Driver;

interface Driver
{
    public function process(string $text): string;
}
