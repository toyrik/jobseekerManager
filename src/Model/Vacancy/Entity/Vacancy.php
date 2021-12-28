<?php

namespace App\Model\Vacancy\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="vacancies")
 */
class Vacancy
{
    /**
     * @ORM\Column(type="vacancy_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @var string
     * @ORM\Column(type="string", name="title")
     */
    private string $title;
    /**
     * @var string
     * @ORM\Column(type="string", name="description")
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
