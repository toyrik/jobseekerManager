<?php

namespace App\Model\Vacancy\Entity;

use App\Model\Person\Entity\Person\Id as PersonId;
use App\Model\Person\Entity\Person\Person;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table (name="vacancy_membersips", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"vacancy_id", "person_id"})
 * })
 */
class Membership
{
    /**
     * @var string
     * @ORM\Column (type="guid")
     * @ORM\Id
     */
    private $id;
    /**
     * @var Vacancy
     * @ORM\ManyToOne(targetEntity="Vacancy", inversedBy="memberships")
     * @ORM\JoinColumn(name="vacancy_id", referencedColumnName="id", nullable=false)
     */
    private $vacancy;
    /**
     * @var $person
     * @ORM\ManyToOne (targetEntity="App\Model\Person\Entity\Person\Person")
     * @ORM\JoinColumn (name="person_id", referencedColumnName="id", nullable=false)
     */
    private $person;

    public function __construct(Vacancy $vacancy, Person $person)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->vacancy = $vacancy;
        $this->person = $person;
    }

    public function isForPerson(PersonId $id): bool
    {
        return $this->person->getId()->isEqual($id);
    }
}
