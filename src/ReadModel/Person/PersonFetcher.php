<?php

namespace App\ReadModel\Person;

use App\Model\Person\Entity\Person\Person;
use App\ReadModel\Person\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PersonFetcher
{
    private $connection;
    private $paginator;
    private $repository;

    public function __construct(
        Connection $connection,
        EntityManagerInterface $em,
        PaginatorInterface $paginator
    )
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
        $this->repository = $em->getRepository(Person::class);
    }

    public function all(Filter$filter, int $page, int $size): PaginationInterface
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'date',
                'name_first ||\' \'|| name_last AS name',
                'email',
                'person_phone AS phone'
            )
            ->from('persons');


        if ($filter->email) {
            $stmt->andWhere($stmt->expr()->like('LOWER(email)', ':email'));
            $stmt->setParameter('email', '%' . mb_strtolower($filter->email) . '%');
        }

        $stmt->orderBy('name_first');

        return $this->paginator->paginate($stmt, $page, $size);
    }

    public function listIds()
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name_first ||\' \'|| name_last AS name',
            )
            ->from('persons')
            ->orderBy('name');
        return $stmt->fetchAllAssociative();
    }

    public function find(string $id):? Person
    {
        return $this->repository->find($id);
    }

}
