<?php

namespace App\Model\Vacancy\UseCase\Edit;

use App\Model\Vacancy\Entity\Vacancy;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $title;

    public $description;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromVacancy(Vacancy $vacancy): self
    {
        $command = new self($vacancy->getId()->getValue());
        $command->title = $vacancy->getTitle();
        $command->description = $vacancy->getDescription();

        return $command;
    }
}
