<?php

namespace App\Controller\Person;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Person\Entity\Person\Person;
use App\ReadModel\Person\Filter;
use App\ReadModel\Person\PersonFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Person\UseCase\Create;
use App\Model\Person\UseCase\Edit;
use App\Model\Person\UseCase\Network;

/**
 * @Route ("/persons")
 */
class PersonController extends AbstractController
{
    private const PER_PAGE = 10;
    private $errors;
    private PersonFetcher $fetcher;

    public function __construct(
        PersonFetcher $fetcher,
        ErrorHandler $handler
    )
    {
        $this->fetcher = $fetcher;
        $this->errors = $handler;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("", name="persons")
     */
    public function index(Request $request): Response
    {
        $filter = new Filter\Filter();
        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $this->fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE
        );

        return $this->render('app/person/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     * @Route ("/create", name="person.create")
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('persons');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render( 'app/person/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Person $person
     * @param Request $request
     * @param Edit\Handler $editHandler
     * @param Network\Attach\Handler $networkHandler
     * @return Response
     * @Route ("/{id}", name="person.show", requirements={"id"=Guid::PATTERN})
     */
    public function show(
        Person $person,
        Request $request,
        Edit\Handler $editHandler,
        Network\Attach\Handler $networkHandler
    ): Response
    {
        $editCommand = Edit\Command::fromPerson($person);
        $editForm = $this->createForm(Edit\Form::class, $editCommand);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $editHandler->handle($editCommand);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        $networkCommand = new Network\Attach\Command($person->getId()->getValue());
        $networkForm = $this->createForm(Network\Attach\Form::class, $networkCommand);
        $networkForm->handleRequest($request);
        if ($networkForm->isSubmitted() && $networkForm->isValid()) {
            try {
                $networkHandler->handle($networkCommand);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/person/show/show.html.twig', [
            'person' => $person,
            'edit_form' => $editForm->createView(),
            'network_form' => $networkForm->createView(),
        ]);
    }
}
