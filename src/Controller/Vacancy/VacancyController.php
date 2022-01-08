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
use App\Model\Vacancy\UseCase\Membership;

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
     * @Route("/create", name="vacancy.create")
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
     * @Route ("/{id}", name="vacancy.show")
     * @param Request $request
     * @param Vacancy $vacancy
     * @param Status\Handler $statusHandler
     * @return Response
     */
    public function show(
        Request $request,
        Vacancy $vacancy,
        Status\Handler $statusHandler
    ): Response
    {
        $statusCommand = Status\Command::fromVacancy($vacancy);
        $statusForm = $this->createForm(Status\Form::class, $statusCommand);
        $statusForm->handleRequest($request);
        if ($statusForm->isSubmitted() && $statusForm->isValid()) {
            try {
                $statusHandler->handle($statusCommand);
                return $this->redirectToRoute('vacancies', ['id' => $vacancy->getId()]);
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
     * @Route("/{id}/edit", name="vacancy.edit")
     * @param Vacancy $vacancy
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(
        Vacancy $vacancy,
        Request $request,
        Edit\Handler $handler
    ): Response
    {
        $command = Edit\Command::fromVacancy($vacancy);

        $mainForm = $this->createForm(Edit\Form::class, $command);
        $mainForm->handleRequest($request);

        if ($mainForm->isSubmitted() && $mainForm->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('vacancy.show',['id' => $vacancy->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/vacancy/edit.html.twig',[
            'vacancy' => $vacancy,
            'form' => $mainForm->createView()
        ]);
    }

    /**
     * @Route ("/{id}/list/persons", name="vacancy.list.persons")
     * @param Vacancy $vacancy
     * @param Request $request
     * @return Response
     */
    public function settingsPerson(Vacancy $vacancy, Request $request): Response
    {
        return $this->render('app/vacancy/membership/index.html.twig', [
            'vacancy' => $vacancy,
            'memberships' => $vacancy->getMemberships()
        ]);
    }

    /**
     * @Route ("/{id}/assign/persons", name="vacancy.assign.persons")
     * @param Vacancy $vacancy
     * @param Request $request
     * @param Membership\Add\Handler $handler
     * @return Response
     */
    public function assignPerson(Vacancy $vacancy, Request $request, Membership\Add\Handler $handler): Response
    {
        $command = new Membership\Add\Command($vacancy->getId()->getValue());

        $form = $this->createForm(Membership\Add\Form::class, $command, ['vacancy' => $vacancy->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('vacancy.list.persons', ['id' => $vacancy->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/vacancy/membership/assign.html.twig', [
            'vacancy' => $vacancy,
            'form' => $form->createView(),
        ]);
    }

}
