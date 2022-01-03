<?php

namespace App\Controller\Vacancy;

use App\ReadModel\Vacancy\VacancyFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/vacancies")
 */
class VacancyController extends AbstractController
{
    private $fetcher;

    public function __construct(VacancyFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @Route ("", name="vacancies")
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function index():Response
    {
        $vacancies = $this->fetcher->all();

        return $this->render('vacancies/index.html.twig',[
            'vacancies' => $vacancies,
        ]);
    }

}
