<?php

namespace App\Model\Person\UseCase\Create;

use App\Model\Flusher;
use App\Model\Person\Entity\Person\Email;
use App\Model\Person\Entity\Person\Id;
use App\Model\Person\Entity\Person\Name;
use App\Model\Person\Entity\Person\Person;
use App\Model\Person\Entity\Person\PersonRepository;
use App\Model\Person\Entity\Person\Phone;

class Handler
{
    private $persons;
    private $flusher;

    public function __construct(PersonRepository $persons, Flusher $flusher)
    {
        $this->persons = $persons;
        $this->flusher = $flusher;
    }

    public function handle(Command $command):void
    {
        $person = new Person(
            Id::next(),
            new \DateTimeImmutable(),
            new Name(
                $command->firstName,
                $command->lastName,
            )
        );
        if ($command->email) {
            $person->changeEmail(new Email($command->email));
        }
        if ($command->phone) {
            $person->changePhone(new Phone($command->phone));
        }

        $this->persons->add($person);

        $this->flusher->flush();
    }
}
