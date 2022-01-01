<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProfilFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
    {
        $profils = ["ADMIN","CANDIDAT"];

        foreach ($profils as  $libelle) {
            $profil = new Profil();
            $profil->setLibelle($libelle);

            $manager->persist($profil);
    
        }
        $manager->flush();
    }
  }
}