<?php

namespace App\ReadModel\Person;

use App\ReadModel\Person\Filter\Filter;
use Doctrine\DBAL\Connection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PersonFetcher
{
    private $connection;
    private $paginator;

    public function __construct(
        Connection $connection,
        PaginatorInterface $paginator
    )
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
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

}
