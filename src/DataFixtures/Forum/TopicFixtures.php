<?php

namespace App\DataFixtures\Forum;

use Faker\Factory;
use App\Entity\Forum\Topic;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TopicFixtures extends Fixture
{
    const TOPICS = [
        ['title' => 'j\'ai mal', 'content' => 'Alors la j\en ai marre', 'reply' => 'cool'],
        ['title' => 'ca va', 'content' => 'salut tout le monde', 'reply' => 'bien'],
    ];
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::TOPICS as $key => $value) {
            $topic = new Topic();
            $topic->setTitle($value['title']);
            $topic->setContent($value['content']);
            $topic->setReply($value['reply']);
            $topic->setCreatedAt(new \DateTime());
            $topic->setSubject($this->getReference('subject_' . $key));
            $manager->persist($topic);
        }  
        $manager->flush();
    }

        public function getDependencies()
        {
            return [
                SubjectFixtures::class,
            ];
        }
}
