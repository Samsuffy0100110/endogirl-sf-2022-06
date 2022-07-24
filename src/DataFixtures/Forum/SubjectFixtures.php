<?php

namespace App\DataFixtures\Forum;

use Faker\Factory;
use App\Entity\Forum\Subject;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $subject = new Subject();
            $subject->setName($faker->sentence(3));
            $subject->setSummary($faker->text(100));
            $subject->setCategory($this->getReference('category_' . $i));
            $this->addReference('subject_' . $i, $subject);
            $manager->persist($subject);
        }

        $manager->flush();
    }
}
