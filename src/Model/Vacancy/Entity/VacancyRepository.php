<?php

namespace App\Model\Vacancy\Entity;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class VacancyRepository
{
    private $em;
    /**
     * @var EntityRepository
     */
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo =$em->getRepository(Vacancy::class);
    }

    public function get(Id $id): Vacancy
    {
        if (!$vacancy = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Vacancy is not found');
        }
        return $vacancy;
    }

    public function add(Vacancy $vacancy): void
    {
        $this->em->persist($vacancy);
    }
}
