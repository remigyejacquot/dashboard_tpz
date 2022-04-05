<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LicenceAgenciesController extends AbstractController
{
    /**
     * @Route("/licence_agencies/{id}", name="licence_agencies")
     */
    public function getLicenceAgencies(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, int $id): Response
    {
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find($id);
        if(!$user){
            throw $this->createNotFoundException(
                'L\'utilisateur '.$id.' ne semble pas exister'
            );
        }
        $type = $user->getIsDev();
        $agencies = $entityManager->getRepository(Agency::class)->findBy(['is_dev'=>$type]);

        return new Response($serializer->serialize($agencies, 'json'));
    }
}
