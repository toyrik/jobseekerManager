<?php

namespace App\Model\Vacancy\UseCase\Edit;

use App\Model\Flusher;
use App\Model\Vacancy\Entity\Id;
use App\Model\Vacancy\Entity\VacancyRepository;

class Handler
{
    private $vacancies;
    private $flusher;

    public function __construct(VacancyRepository $vacancies, Flusher $flusher)
    {
        $this->vacancies = $vacancies;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $vacancy = $this->vacancies->get(new Id($command->id));

        $vacancy->edit(
            $command->title,
            $command->description
        );

        $this->flusher->flush();
    }

}
