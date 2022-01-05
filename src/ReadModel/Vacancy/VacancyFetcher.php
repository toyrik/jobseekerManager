<?php

namespace App\ReadModel\Vacancy;

use App\ReadModel\Vacancy\Filter\Filter;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class VacancyFetcher
{
    private Connection $connection;
    private $paginator;

    public function __construct(Connection $connection ,PaginatorInterface $paginator)
    {
        $this->connection = $connection;
        $this->paginator = $paginator;
    }

    /**
     * @throws Exception
     */
    public function all(Filter $filter, int $page, int $size): PaginationInterface
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                '*'
            )
            ->from('vacancies');

        if ($filter->title) {
            $stmt->andWhere($stmt->expr()->like('LOWER(title)', ':title'));
            $stmt->setParameter('title', '%' . mb_strtolower($filter->title) . '%');
        }

        if ($filter->status) {
            $stmt->andWhere('status = :status');
            $stmt->setParameter('status', $filter->status);
        }


        $stmt->orderBy('date', 'desc');

        return $this->paginator->paginate($stmt, $page, $size);
    }
}
