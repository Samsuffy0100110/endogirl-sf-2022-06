<?php

namespace App\DataFixtures\Forum;

use Faker\Factory;
use App\Entity\Forum\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setName($faker->sentence(3));
            $this->addReference('category_' . $i, $category);
            $manager->persist($category);

        }

        $manager->flush();
    }
}
