<?php

namespace App\DataFixtures;

use App\Model\Person\Entity\Person\Email;
use App\Model\Person\Entity\Person\Id;
use App\Model\Person\Entity\Person\Name;
use App\Model\Person\Entity\Person\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('ru_RU');
        $date = new \DateTimeImmutable('-300 days');
        $gender = $faker->boolean(10) ? 'male' : 'female';

        for($i =0; $i < 5; $i++) {
            $date = $date->modify('+'. $faker->numberBetween(1,4) .'weeks');

            $person = new Person(
                Id::next(),
                $date,
                new Name($faker->firstName($gender), $faker->lastName())
            );

            $person->changeEmail(new Email($faker->email()));
            $person->changePhone($faker->e164PhoneNumber());

            $manager->persist($person);
        }

        $manager->flush();
    }
}
