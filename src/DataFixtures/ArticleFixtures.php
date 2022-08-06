<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new Article();
        $article->setTitle('Les Bienfaits de la CBD');
        $article->setPicture(
            'https://cdn.pixabay.com/photo/2019/09/11/21/23/cbd-4469987_960_720.jpg'
        );
        $article->setContent('There are many variations of passages of Lorem Ipsum available,
        but the majority have suffered alteration in some form, by injected humour,
        or randomised words which don\'t look even slightly believable.
        If you are going to use a passage of Lorem Ipsum, you need to be
        sure there isn\'t anything embarrassing hidden in the middle of text.
        All the Lorem Ipsum generators on the Internet tend to repeat predefined
        chunks as necessary, making this the first true generator on the Internet.
        It uses a dictionary of over 200 Latin words, combined with a handful of
        model sentence structures, to generate Lorem Ipsum which looks reasonable.
        The generated Lorem Ipsum is therefore always free from repetition,
        injected humour, or non-characteristic words etc.');
        $article->setCreatedAt(new DateTime());
        $article->setSlug((new Slugify())->generate($article->getTitle()));
        $article->setIsPublished(true);
        $manager->persist($article);
        $manager->flush();
    }
}
