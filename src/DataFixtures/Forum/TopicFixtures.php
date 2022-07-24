<?php

namespace App\DataFixtures\Forum;

use Faker\Factory;
use App\Entity\Forum\Topic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TopicFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $topic = new Topic();
            $topic->setTitle($faker->sentence(3));
            $topic->setContent($faker->text(100));
            $topic->setReply($faker->text(100));
            $topic->setCreatedAt(new \DateTime());
            $topic->setSubject($this->getReference('subject_' . $i));

            $manager->persist($topic);
        }

        $manager->flush();
    }
}
