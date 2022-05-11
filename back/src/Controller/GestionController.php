<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Agency;
use App\Entity\Tpz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GestionController extends AbstractController
{
    /**
     * @Route("/gestion/groupes/{tpzId}", name="gestion_groupes")
     */
    public function gestionGroupes(EntityManagerInterface $entityManager,int $tpzId) {
        $agenciesDev = $entityManager->getRepository(Agency::class)->findBy(array('tpz' => $tpzId, 'is_dev' => true));
        $agenciesCom = $entityManager->getRepository(Agency::class)->findBy(array('tpz' => $tpzId, 'is_dev' => false));

    }

}