<?php

namespace App\Model\Vacancy\UseCase\Create;

use App\Model\Flusher;
use App\Model\Vacancy\Entity\Vacancy;
use App\Model\Vacancy\Entity\VacancyRepository;
use App\Model\Vacancy\Entity\Id;

class Handler
{
    private $vacancies;
    private $flusher;

    public function __construct(VacancyRepository $vacancies , Flusher $flusher)
    {
        $this->vacancies = $vacancies;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $vacancy = new Vacancy(
            Id::next(),
            $command->title,
            $command->description
        );

        $this->vacancies->add($vacancy);

        $this->flusher->flush();
    }
}
