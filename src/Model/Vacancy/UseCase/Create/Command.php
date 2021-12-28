<?php

namespace App\Model\Vacancy\UseCase\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $title;
    /**
     * @Assert\NotBlank()
     */
    public $description;

}
