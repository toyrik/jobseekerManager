<?php

namespace App\Model\Vacancy\UseCase\Membership\Add;

use App\Model\Flusher;
use App\Model\Person\Entity\Person\PersonRepository;
use App\Model\Person\Entity\Person\Id as PersonId;
use App\Model\Vacancy\Entity\Id as VacancyId;
use App\Model\Vacancy\Entity\VacancyRepository;

class Handler
{
    private $vacancies;
    private $persons;
    private $flusher;

    public function __construct(
        VacancyRepository $vacancies,
        PersonRepository $persons,
        Flusher $flusher
    )
    {
        $this->persons = $persons;
        $this->vacancies = $vacancies;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $vacancy = $this->vacancies->get(new VacancyId($command->vacancy));
        $person = $this->persons->get((new PersonId($command->person)));

        $vacancy->addPerson($person);

        $this->flusher->flush();
    }
}
