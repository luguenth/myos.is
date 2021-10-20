<?php

namespace App\DataFixtures;

use App\Entity\Aiku;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AikuFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $aiku = new Aiku();
        $aiku->setLocale("DE");
        $aiku->setPromptNative(
            "Steckt eure Köpfe
                        zusammen wie Rüben
                        beißt euch 
                        aneinander
                        fest
                        werft das
                        rote Tuch und
                        verhüllt
                        die Sieger der Geschichte
                        dieser Platz
                        gehört euren Worten
                        formt ihn!"
        );
        $aiku->setPrompt(
            "Put your heads together like turnips. Bite yourselves together. 
                    Throw the red cloth and cover the winners of history, 
                    this place belongs to your words. Shape it!"
        );
        $aiku->setImagePath("photo_2021-09-29_16-45-03.jpg");
        // $product = new Product();
        $manager->persist($aiku);

        $manager->flush();
    }
}
