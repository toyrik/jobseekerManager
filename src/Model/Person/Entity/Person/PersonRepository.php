<?php

namespace App\Model\Person\Entity\Person;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class PersonRepository
{
    private $em;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Person::class);
    }

    public function get(Id $id): Person
    {
        /** @var Person $person */
        if(!$person = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Person is not found');
        }
        return $person;
    }

    public function add(Person $person): void
    {
        $this->em->persist($person);
    }
}
