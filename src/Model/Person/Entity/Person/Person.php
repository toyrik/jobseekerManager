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
     * @var string|null
     * @ORM\Column(type="string", name="person_phone", nullable=true)
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
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
}
