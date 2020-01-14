<?php


namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Role;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements DataPersisterInterface
{
    private $userPasswordEncoder;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
        $this->entityManager = $entityManager;
    }

    public function supports($data): bool
    {
        return $data instanceof Users;
    }

    
    public function persist($data)
    {
        $data->setPassword($this->userPasswordEncoder->encodePassword($data, $data->getPassword()))
            ->setRoles([$data->getRole()->getLibelle()]);
        $data->eraseCredentials();

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}