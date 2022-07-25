<?php

namespace App\DataFixtures;

use App\Entity\Links;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LinkFixtures extends Fixture
{
    const LINKS = [
        ['link' => '<div><a href="https://www.endofrance.org/">Endo France</a></div>', 'summary' => 'EndoFrance est la première association de lutte contre l’endométriose créée en France en 2001. Depuis 2018, elle est agréée par le ministère de la Santé. Son équipe de bénévoles, son comité scientifique composé de médecins spécialistes reconnus pour leurs compétences, sa Marraine Laëtitia Milot et son parrain Thomas Ramos, militent ensemble pour faire connaitre cette maladie.'],
        ['link' => '<div><a href="https://www.endomind.org/">Endo France</a></div>', 'summary' => 'Endomind souhaite changer le regard porté sur l’endométriose, et faire découvrir cette
        maladie au plus grand nombre afin d’améliorer le délai de diagnostic et la prise en charge
        globale.'],
        ['link' => '<div><a href="https://endoaction.jimdofree.com/">Endo France</a></div>', 'summary' => 'EndoAction, anciennement baptisée MEMS Métropole, est une association basée dans le nord
        de la France, mais dont le champ d’action s’élargit à toute la métropole. Ici encore, l’association
        s’est fondée autour d’endogirls dans la souffrance, et dans le désir de trouver du soutien, du
        réconfort, de l’échange avec d’autres personnes concernées par l’endométriose.'],
        ['link' => '<div><a href="https://www.info-endometriose.fr/">Endo France</a></div>', 'summary' => 'Info-endométriose est le fruit d’une heureuse rencontre : celle de Julie Gayet, actrice,
        réalisatrice et productrice, avec le Dr Chrysoula Zacharopoulou, chirurgienne gynécologue
        spécialisée dans l’endométriose et députée européenne. Avec l’aide de Cécile Togni-Purtschet,
        elles veulent informer, éduquer et mobiliser pour que l’endométriose soit reconnue comme
        grande cause de santé mondiale d’ici 2030.'],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::LINKS as $value) {
            $link = new Links();
            $link->setLink($value['link']);
            $link->setSummary($value['summary']);
            $manager->persist($link);
        }

        $manager->flush();
    }
}
