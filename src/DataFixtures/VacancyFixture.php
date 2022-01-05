<?php

namespace App\DataFixtures;

use App\Model\Vacancy\Entity\Vacancy;
use App\Model\Vacancy\Entity\Id;
use App\Model\Vacancy\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class VacancyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('ru_RU');
        $date = new \DateTimeImmutable('-300 days');

        for($i = 0; $i < 20; $i++) {
            $date = $date->modify('+'. $faker->numberBetween(1,30) .'days');

            $vacancy = new Vacancy(
                Id::next(),
                $date,
                trim($faker->sentence(random_int(2, 3)), '.'),
                $faker->paragraphs(3, true)
            );
            if($faker->boolean(60)) {
                $vacancy->changeStatus(
                    new Status($faker->randomElement([
                        Status::ACTIVE,
                        Status::ARCHIVE
                    ]))
                );
            }

            $manager->persist($vacancy);
        }
        $manager->flush();
    }
}
