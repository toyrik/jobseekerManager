<?php

namespace App\Model\Vacancy\UseCase\Membership\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank
     */
    public $vacancy;
    /**
     * @Assert\NotBlank
     */
    public $person;

    public function __construct(string $vacancy)
    {
        $this->vacancy = $vacancy;
    }
}
