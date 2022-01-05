<?php

namespace App\Model\Vacancy\UseCase\Status;

use App\Model\Flusher;
use App\Model\Vacancy\Entity\Id;
use App\Model\Vacancy\Entity\Status;
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
        $vacancies = $this->vacancies->get(new Id($command->id));

        $vacancies->changeStatus(
            new Status($command->status)
        );

        $this->flusher->flush();
    }
}
