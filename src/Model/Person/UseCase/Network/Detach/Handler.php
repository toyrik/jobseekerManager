<?php

namespace App\Model\Person\UseCase\Network\Detach;

use App\Model\Flusher;
use App\Model\Person\Entity\Person\Id;
use App\Model\Person\Entity\Person\PersonRepository;

class Handler
{
    private $persons;
    private $flusher;

    public function __construct(PersonRepository $persons, Flusher $flusher)
    {
        $this->persons = $persons;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $person = $this->persons->get(new Id($command->person));

        $person->detachNetwork(
            $command->network,
            $command->person
        );

        $this->flusher->flush();
    }
}
