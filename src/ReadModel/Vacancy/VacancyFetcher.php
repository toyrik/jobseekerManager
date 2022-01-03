<?php

namespace App\ReadModel\Vacancy;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

class VacancyFetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'title'
            )
            ->from('vacancies')
            ->orderBy('id');

        return $stmt->fetchAllAssociative();
    }
}
