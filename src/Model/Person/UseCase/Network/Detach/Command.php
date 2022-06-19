<?php

namespace App\Model\Person\UseCase\Network\Detach;

class Command
{
    /**
     * @var string
     */
    public $person;
    /**
     * @var string
     */
    public $network;
    /**
     * @var string
     */
    public $identity;

    public function __construct(string $person, string $network, string $identity)
    {
        $this->person = $person;
        $this->network = $network;
        $this->identity = $identity;
    }
}
