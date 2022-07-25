<?php

namespace App\DataFixtures\Forum;

use App\Service\Slugify;
use App\Entity\Forum\Subject;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Forum\CategoryFixtures;

class SubjectFixtures extends Fixture
{
    public const SUBJECTS = [
        [
            'category' => 'Les enfants',
            'name' => 'Comment leur faire comprendre',
            'summary' => 'Les enfants sont des personnes qui ont un lien avec l\'homme et la femme. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.'
        ],
        [
            'category' => 'Les enfants',
            'name' => 'Ils m\'aident',
            'summary' => 'Tous les jours, les enfants sont en train de se sentir plus enfants. Ils sont donc des personnes qui ont un lien avec l\'homme et la femme.'
        ],
        [
            'category' => 'Douleurs',
            'name' => 'Les maux de ventres',
            'summary' => 'Les maux de ventres sont des maux qui se produisent lorsque l\'on souffre. Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Douleurs',
            'name' => 'Les maux de tête',
            'summary' => 'Les maux de tête sont des maux qui se produisent lorsque l\'on souffre. Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'La séxualité',
            'name' => 'Les relations sexuelles',
            'summary' => 'Les relations sexuelles sont des relations qui se produisent lorsque l\'on souffre. Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'La séxualité',
            'name' => 'Les actes sexuels douloureux',
            'summary' => 'Les actes sexuels douloureux sont des actes qui se produisent lorsque l\'on souffre. Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Médecine',
            'name' => 'Les médecins sont-ils bons ?',
            'summary' => 'Les médecins sont-ils bons ? Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Médecine',
            'name' => 'Ont nous méprisent',
            'summary' => 'Ont nous méprisent Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'La matérnité',
            'name' => 'Comment tomber enceinte',
            'summary' => 'Comment tomber enceinte Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'La matérnité',
            'name' => 'Les effets des hormones',
            'summary' => 'Les effets des hormones sur la fécondation'
        ],
        [
            'category' => 'Les maladies',
            'name' => 'Les autres maladies',
            'summary' => 'Les maladies Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Les maladies',
            'name' => 'Mal de dos et endométriose',
            'summary' => 'Le mal de dos et l\'endométriose.'
        ],
        [
            'category' => 'Blabla',
            'name' => 'Les séries qu vous regardez',
            'summary' => 'Parlez- nous des séries que vous regardez en ce moment.'
        ],
        [
            'category' => 'Blabla',
            'name' => 'Le sport que vous pratiquez',
            'summary' => 'On le sait ? Parlez- nous du sport que vous pratiquez en ce moment.'
        ],
        [
            'category' => 'Autres',
            'name' => 'Je suis moins sociable',
            'summary' => 'Autres Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Autres',
            'name' => 'Les animaux',
            'summary' => 'Le bienfait des animaux Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Par régions',
            'name' => 'Aquitaine',
            'summary' => 'Aquitaine Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'Par régions',
            'name' => 'Bretagne',
            'summary' => 'Bretagne Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'J\'en peux plus',
            'name' => 'La douleur est horrible',
            'summary' => 'La douleur est horrible Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
        [
            'category' => 'J\'en peux plus',
            'name' => 'Ils ne comprenent pas',
            'summary' => 'Ils ne comprenent pas Ils sont donc des maux qui se produisent lorsque l\'on souffre.'
        ],
    ];

    private Slugify $slug;

    public function __construct(Slugify $slugify)
    {
        $this->slug = $slugify;
    }
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::SUBJECTS as $sujet) {
            $subject = new Subject();
            $subject->setName($sujet['name']);
            $subject->setSummary($sujet['summary']);
            $subject->setCategory($this->getReference($sujet['category']));
            $subject->setSlug($this->slug->generate($sujet['name']));
            $this->addReference($sujet['name'], $subject);
            $manager->persist($subject);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
