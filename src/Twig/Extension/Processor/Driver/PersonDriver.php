<?php

namespace App\Twig\Extension\Processor\Driver;

use App\ReadModel\Person\PersonFetcher;
use Twig\Environment;

class PersonDriver implements Driver
{
    private const PATTERN = '/\@[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/i';

    private $persons;
    private $twig;

    public function __construct(PersonFetcher $persons, Environment $twig)
    {
        $this->persons = $persons;
        $this->twig = $twig;
    }

    public function process(string $text): string
    {
        return preg_replace_callback(self::PATTERN, function (array $matches) {
            $id = ltrim($matches[0], '@');
            if (!$person = $this->persons->find($id)) {
                return $matches[0];
            }
            return $this->twig->render('processor/person.html.twig', [
                'person' => $person,
            ]);
        }, $text);
    }
}
