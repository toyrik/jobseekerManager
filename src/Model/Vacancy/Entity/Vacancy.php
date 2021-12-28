<?php

namespace App\Model\Vacancy\Entity;

class Vacancy
{
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var string
     */
    private string $title;
    /**
     * @var string
     */
    private string $description;

    public function __construct(Id $id, string $title, string $description)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
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
