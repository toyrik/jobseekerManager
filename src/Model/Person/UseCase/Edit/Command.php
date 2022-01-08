<?php

namespace App\Model\Person\UseCase\Edit;

use App\Model\Person\Entity\Person\Person;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank
     */
    public $firstName;

    /**
     * @Assert\NotBlank
     */
    public $lastName;

    public $email;
    public $phone;



    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromPerson(Person $person): self
    {
        $command = new self($person->getId()->getValue());
        $command->email = $person->getEmail()?->getValue();
        $command->firstName = $person->getName()->getFirst();
        $command->lastName = $person->getName()->getLast();
        return $command;
    }

}
