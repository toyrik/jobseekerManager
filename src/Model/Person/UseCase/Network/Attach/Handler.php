<?php

namespace App\Model\Person\UseCase\Network\Attach;

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
        if ($this->persons->hasByNetwork($command->network, $command->identity)) {
            throw new \DomainException('Profile is already in use.');
        }

        $person = $this->persons->get(new Id($command->person));

        $person->attachNetwork(
            $command->network,
            $command->identity
        );

        $this->flusher->flush();
    }
}
