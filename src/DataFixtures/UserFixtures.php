<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // 1. Administrateur
        $admin = new User();
        $admin->setEmail('admin@betplatform.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        // Si tu as ajouté des champs par défaut pour les limites, initialise-les ici
        $manager->persist($admin);

        // 2. Gestionnaire
        $gestionnaire = new User();
        $gestionnaire->setEmail('manager@betplatform.com');
        $gestionnaire->setRoles(['ROLE_MANAGER']);
        $gestionnaire->setPassword($this->passwordHasher->hashPassword($gestionnaire, 'manager123'));
        $manager->persist($gestionnaire);

        // 3. Utilisateurs (Parieurs)
        for ($i = 1; $i <= 5; $i++) {
            $user = new User();
            $user->setEmail("joueur{$i}@betplatform.com");
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'joueur123'));

             $user->setBalance(1000.00);

            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        $manager->flush();
    }
}
