<?php

namespace App\Controller\Vacancy;

use App\ReadModel\Vacancy\VacancyFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Vacancy\UseCase\Create;

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

        return $this->render('vacancy/index.html.twig',[
            'vacancies' => $vacancies,
        ]);
    }

    /**
     * @Route("/create", name="users.create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            try{
                $handler->handle($command);
                return $this->redirectToRoute('vacancies');
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('vacancy/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
