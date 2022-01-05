<?php

namespace App\ReadModel\Vacancy;

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
    public function all(int $page, int $size): PaginationInterface
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'title',
                'status'
            )
            ->from('vacancies')
            ->orderBy('id');

        return $this->paginator->paginate($stmt, $page, $size);
    }
}
