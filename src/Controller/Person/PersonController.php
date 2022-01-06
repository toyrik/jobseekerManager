<?php

namespace App\Controller\Person;

use App\Controller\ErrorHandler;
use App\ReadModel\Person\Filter;
use App\ReadModel\Person\PersonFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\Vacancy\UseCase\Create;

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
}
