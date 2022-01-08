<?php

namespace App\Model\Person\Entity\Person;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="persons")
 */
class Person
{
    /**
     * @ORM\Column(type="person_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var Email|null
     * @ORM\Column(type="person_email", nullable=true)
     */
    private $email;

    /**
     * @var Name
     * @ORM\Embedded(class="Name")
     */
    private $name;

    /**
     * @var JobTitle|null
     * @ORM\Column(type="job_title", nullable=true)
     */
    private $jobTitle;

    /**
     * @var Phone|null
     * @ORM\Column(type="person_phone", name="person_phone", nullable=true)
     */
    private $phone;

    public function __construct(Id $id, \DateTimeImmutable $date, Name $name)
    {
        $this->id = $id;
        $this->date = $date;
        $this->name = $name;
    }

    public function edit(Email $email, Name $name): void
    {
        $this->email = $email;
        $this->name = $name;
    }

    public function changeName(Name $name): void
    {
        $this->name = $name;
    }

    public function changeJobTitle(JobTitle $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    public function changeEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function changePhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Email|null
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Phone|null
     */
    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    /**
     * @return JobTitle|null
     */
    public function getJobTitle(): ?JobTitle
    {
        return $this->jobTitle;
    }
}
