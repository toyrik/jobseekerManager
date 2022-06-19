<?php

namespace App\Model\Person\UseCase\Network\Attach;

use App\Model\Person\Entity\Person\Person;

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

    public function __construct(string $person)
    {
        $this->person = $person;
    }

}
