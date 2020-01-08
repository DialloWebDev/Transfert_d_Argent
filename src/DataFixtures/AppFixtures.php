<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $role_admin_system = new Role();
        $role_admin_system->setLibelle("ROLE_ADMIN_SYSTEM");
        $manager->persist($role_admin_system);

        $role_admin = new Role();
        $role_admin->setLibelle("ROLE_ADMIN");
        $manager->persist($role_admin);

        $role_caissier = new Role();
        $role_caissier->setLibelle("ROLE_CAISSIER");
        $manager->persist($role_caissier);

        $this->addReference('role_admin_system',$role_admin_system);
        $this->addReference('role_admin',$role_admin);
        $this->addReference('role_caissier',$role_caissier);
        
        $roleAdmdinSystem = $this->getReference('role_admin_system');
        $roleAdmin = $this->getReference('role_admin');
        $roleCaissier = $this->getReference('role_caissier');

        $users = new Users();
        $users->setEmail("admin@gmail.com");
        $users->setRole($roleAdmdinSystem);
        $users->setPassword($this->encoder->encodePassword($users, "admin"));
        $users->setRoles(array("ROLE_ADMIN_SYSTEM"));
        $users->setPrenom("Mamadou");
        $users->setNom("Diallo");
        $users->setTel("773916006");
        $users->setIsActif("1");
        $manager->persist($users);
        $manager->flush();
    }
}