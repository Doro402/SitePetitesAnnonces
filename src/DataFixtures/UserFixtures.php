<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Repository\ProfilRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;
    private $profilRepository;

    public function __construct(UserPasswordEncoderInterface $encoder, ProfilRepository $profilRepository) {
        $this->encoder = $encoder;
        $this->profilRepository=$profilRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        $profil=$this->profilRepository->findOneBy(["id"=>1]);
        for ($i = 1; $i <= 8; $i++) {
            $user = new User();
            $user->setProfile($profil);
            $user->setUsername($faker->username);
            $user->setNom($faker->firstName);
            $user->setPseudo($faker->username);
            $user->setPrenom($faker->lastName);
            $user->setEmail($faker->email);
            $user->setAdresse("adresse $i");
            $user->setTelephone("77567432$i");
            $user->setCp("1299");
            $user->setVille($faker->city);
            $user->setCivilite('mr');
            //Génération des Users
            $password = $this->encoder->encodePassword($user, '1234');
            $user->setPassword($password);
            $manager->persist($user);

            
        }
        $manager->flush();
    }
       
       
}

