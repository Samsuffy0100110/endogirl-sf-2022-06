<?php

namespace App\DataFixtures\Forum;

use Faker\Factory;
use App\Service\Slugify;
use App\Entity\Forum\Topic;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class TopicFixtures extends Fixture
{
    const TOPICS = [
        [
            'subject' => 'Comment leur faire comprendre',
            'title' => 'Mes enfants me comprennent',
            'content' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
            'reply' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
        ],
        [
            'subject' => 'Comment leur faire comprendre',
            'title' => 'Ils sont là',
            'content' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
            'reply' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
        ],
        [
            'subject' => 'Comment leur faire comprendre',
            'title' => 'Ma fille est là',
            'content' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
            'reply' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
        ],
        [
            'subject' => 'Comment leur faire comprendre',
            'title' => 'Mon fils est là',
            'content' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
            'reply' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
        ],
        [
            'subject' => 'Comment leur faire comprendre',
            'title' => 'Le chat est là',
            'content' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
            'reply' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
        ],
        [
            'subject' => 'Les relations sexuelles',
            'title' => 'La pénétration',
            'content' => 'La pénétration est un acte',
            'reply' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.',
        ],
    ];
    
    private Slugify $slug;

    public function __construct(Slugify $slugify)
    {
        $this->slug = $slugify;
    }
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::TOPICS as $value) {
            $topic = new Topic();
            $topic->setTitle($value['title']);
            $topic->setContent($value['content']);
            $topic->setCreatedAt(new \DateTime());
            $topic->setSubject($this->getReference($value['subject']));
            $topic->setSlug($this->slug->generate($value['title']));
            // $topic->setUser($this->getReference($value['user']));
            $manager->persist($topic);
        }  
        $manager->flush();
    }

        public function getDependencies()
        {
            return [
                SubjectFixtures::class,
                UserFixtures::class,
            ];
        }
}
