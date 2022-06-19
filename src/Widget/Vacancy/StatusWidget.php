<?php

namespace App\Widget\Vacancy;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class StatusWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('vacancy_status', [$this, 'status'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function status(Environment $twig, string $status): string
    {
        return $twig->render('widget/vacancy/status.html.twig', [
            'status' => $status
        ]);
    }
}
