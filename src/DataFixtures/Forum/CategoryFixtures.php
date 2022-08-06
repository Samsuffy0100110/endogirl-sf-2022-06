<?php

namespace App\DataFixtures\Forum;

use App\Entity\Forum\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public const CATEGORIES = [
        'Les enfants',
        'Douleurs',
        'La séxualité',
        'Médecine',
        'La matérnité',
        'Les maladies',
        'Blabla',
        'Autres',
        'Par régions',
        'J\'en peux plus',
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $name) {
            $category = new Category();
            $category->setName($name);
            $this->addReference($name, $category);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
