<?php

namespace App\Model\Vacancy\Entity;

use App\Model\Person\Entity\Person\Id as PersonId;
use App\Model\Person\Entity\Person\Person;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="vacancies")
 */
class Vacancy
{
    /**
     * @ORM\Column(type="vacancy_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @var string
     * @ORM\Column(type="string", name="title")
     */
    private string $title;
    /**
     * @var string
     * @ORM\Column(type="string", name="description")
     */
    private string $description;
    /**
     * @var Status
     * @ORM\Column(type="vacancy_status", length=16)
     */
    private Status $status;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;
    /**
     * @var ArrayCollection|Membership[]
     * @ORM\OneToMany(targetEntity="Membership", mappedBy="vacancy", orphanRemoval=true, cascade={"all"})
     */
    private $memberships;

    public function __construct(Id $id, \DateTimeImmutable $date, string $title, string $description)
    {
        $this->id = $id;
        $this->date = $date;
        $this->title = $title;
        $this->description = $description;
        $this->status = Status::new();
        $this->memberships = new ArrayCollection();
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    public function edit(string $title, string $description): void
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function changeStatus(Status $status): void
    {
        if ($this->status->isEqual($status)) {
            throw new \DomainException('Status is alredy same');
        }
        $this->status = $status;
    }

    public function hasMember(PersonId $id): bool
    {
        foreach ($this->memberships as $membership) {
            if ($membership->isForPerson($id)) {
                return true;
            }
        }
        return false;
    }

    public function addPerson(Person $person)
    {
        foreach ($this->memberships as $membership) {
            if ($membership->isForPerson($person->getId())) {
                throw new \DomainException('Person is already exists');
            }
        }
        $this->memberships->add(new Membership($this, $person));
    }

    public function removePerson(PersonId $person)
    {
        foreach ($this->memberships as $membership) {
            if ($membership->isForPerson($person)) {
                $this->memberships->removeElement($membership);
            }
        }
        throw new \DomainException('Person is not found');
    }

    public function isNew():bool
    {
        return $this->status->isNew();
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getMemberships()
    {
        return $this->memberships->toArray();
    }

    public function getMembership(PersonId $id): Membership
    {
        foreach ($this->memberships as $membership) {
            if ($membership->isForPerson($id)) {
                return $membership;
            }
        }
        throw new \DomainException('Person is nof found');
    }
}
