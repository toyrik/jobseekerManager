<?php

namespace App\Controller\Vacancy;

use App\Controller\ErrorHandler;
use App\Model\Vacancy\Entity\Vacancy;
use App\ReadModel\Vacancy\Filter;
use App\ReadModel\Vacancy\VacancyFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Vacancy\UseCase\Create;
use App\Model\Vacancy\UseCase\Edit;
use App\Model\Vacancy\UseCase\Status;

/**
 * @Route ("/vacancies")
 */
class VacancyController extends AbstractController
{
    private const PER_PAGE = 10;
    private ErrorHandler $errors;
    private VacancyFetcher $fetcher;

    public function __construct(VacancyFetcher $fetcher, ErrorHandler $handler)
    {
        $this->fetcher = $fetcher;
        $this->errors = $handler;
    }

    /**
     * @Route ("", name="vacancies")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\DBAL\Exception
     */
    public function index(Request $request):Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $this->fetcher->all(
            $filter,
            $request->query->getInt('page',1),
            self::PER_PAGE
        );

        return $this->render('app/vacancy/index.html.twig',[
            'pagination' => $pagination,
            'form' => $form->createView()
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
                $this->addFlash('success', 'Vacancy successfully added');
                return $this->redirectToRoute('vacancies');
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/vacancy/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/{id}", name="vacancies.show")
     * @param Vacancy $vacancy
     * @param Request $request
     * @param Status\Handler $statusHandler
     * @return Response
     */
    public function show(
        Vacancy $vacancy,
        Request $request,
        Status\Handler $statusHandler
    ): Response
    {
        $statusCommand = Status\Command::fromVacancy($vacancy);
        $statusForm = $this->createForm(Status\Form::class, $statusCommand);
        $statusForm->handleRequest($request);
        if ($statusForm->isSubmitted() && $statusForm->isValid()) {
            try {
                $statusHandler->handle($statusCommand);
                return $this->redirectToRoute('vacancies.show', ['id' => $vacancy->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/vacancy/show.html.twig', [
            'vacancy' => $vacancy,
            'statusForm' => $statusForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vacancies.edit")
     *
     */
    public function edit(
        Vacancy $vacancy,
        Request $request,
        Edit\Handler $handler
    ): Response
    {
        $command = Edit\Command::fromVacancy($vacancy);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('vacancies.show',['id' => $vacancy->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/vacancy/edit.html.twig',[
            'vacancy' => $vacancy,
            'form' => $form->createView(),
        ]);
    }

}
