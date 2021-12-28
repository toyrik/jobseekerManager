<?php

namespace App\Model\Entity\Vacancy;

class Vacancy
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;

    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
