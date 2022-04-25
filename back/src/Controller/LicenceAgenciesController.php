<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\User;
use App\Repository\AgencyRepository;
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
     * @var AgencyRepository $agencyRepository
     */
    private $agencyRepository;

    /**
     * @param AgencyRepository $agencyRepository
     */
    public function __construct(AgencyRepository $agencyRepository)
    {
        $this->agencyRepository = $agencyRepository;
    }


    /**
     * @Route("/user_licence_agencies/{id}", name="user_licence_agencies")
     */
    public function getUserLicenceAgencies(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, int $id): Response
    {
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find($id);
        if(!$user){
            throw $this->createNotFoundException(
                'L\'utilisateur '.$id.' ne semble pas exister'
            );
        }
        $type = $user->getIsDev();

        $agencies = $this->agencyRepository->retrieveUserTypeAgencies($user);

        return new Response($serializer->serialize($agencies, 'json'));
    }

    /**
     * @Route("/licence_agencies/{type}", name="other_licence_agencies")
     */
    public function getLicenceAgencies(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, string $type): Response
    {
        $value = $type === 'dev';
        $agencies = $this->agencyRepository->retrieveAgencies($value);

        return new Response($serializer->serialize($agencies, 'json'));
    }
}
