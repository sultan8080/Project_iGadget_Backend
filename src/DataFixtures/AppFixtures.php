<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);


         // Création d'un user "normal"
         $user = new Users();
         $user->setEmail("user@bookapi.com");
         $user->setRoles(["ROLE_USER"]);
         $user->setPassword($this->userPasswordHasher->hashPassword($user, "123456"));
         $manager->persist($user);
         
         // Création d'un user admin
         $userAdmin = new Users();
         $userAdmin->setEmail("admin@bookapi.com");
         $userAdmin->setRoles(["ROLE_ADMIN"]);
         $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
         $manager->persist($userAdmin);
    

        $manager->flush();
    }
}
