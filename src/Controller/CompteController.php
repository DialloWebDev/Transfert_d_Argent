<?php

namespace App\Controller;

use App\Entity\Compte;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/new", name="compte_partenaire")
     */
    public function nouveauPartenaire( EntityManager $entitymanager)
    {
       $compte new Compte
       
    }
}
