<?php

namespace App\ReadModel\Vacancy\Filter;

use App\Model\Vacancy\Entity\Status;

class Filter
{
    public $title;
    public $status = Status::ACTIVE;
}
