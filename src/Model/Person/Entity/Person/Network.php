<?php

namespace App\Model\Person\Entity\Person;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="person_networks", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"network", "identity"})
 * })
 */
class Network
{
    public const VK = 'https://vk.com/';
    public const HABR = 'https://career.habr.com/';
    public const TELEGRAM = 'https://telegram.me/';

    /**
     * @var string
     * @ORM\Column (type="guid")
     * @ORM\Id
     */
    private $id;
    /**
     * @var Person
     * @ORM\ManyToOne (targetEntity="Person", inversedBy="networks")
     * @ORM\JoinColumn (name="person_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $person;
    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $network;
    /**
     * @var string
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $identity;

    public function __construct(Person $person, string $network, string $identity)
    {
        Assert::oneOf($network,[
            self::VK,
            self::HABR,
            self::TELEGRAM,
        ]);

        $this->id = Uuid::uuid4()->toString();
        $this->person = $person;
        $this->network = $network;
        $this->identity = $identity;
    }

    public function isForNetwork(string $network): bool
    {
        return $this->network === $network;
    }

    public function getNetwork(): string
    {
        return $this->network;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }
}
