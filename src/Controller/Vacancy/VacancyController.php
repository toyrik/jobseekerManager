<?php

namespace App\Controller\Vacancy;

use App\Model\Vacancy\Entity\Vacancy;
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
    private const PER_PAGE = 10;
    private VacancyFetcher $fetcher;

    public function __construct(VacancyFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @Route ("", name="vacancies")
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function index(Request $request):Response
    {
        $pagination = $this->fetcher->all($request->query->getInt('page',1), self::PER_PAGE);

        return $this->render('vacancy/index.html.twig',[
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/create", name="vacancies.create")
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

    /**
     * @Route ("/{id}", name="vacancies.show")
     * @param Vacancy $vacancy
     * @return Response
     */
    public function show(Vacancy $vacancy): Response
    {
        return $this->render('vacancy/show.html.twig', compact('vacancy'));
    }

}
