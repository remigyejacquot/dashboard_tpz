<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Tpz;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @ApiResource()
 * @Route("/addUsers")
 */
class UserController extends AbstractController
{
    /**
     * @Route ("/register", name="add_user")
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param Request $request
     *
     * @return Response
     */
    public function register(
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        Request $request
    ){
        $data = $request->getContent();
        /** @var User $user */
        $user = $serializer->deserialize($data, User::class, 'json');
        $user->setPassword(password_hash($user->getPassword(), null));
        /** @var Tpz[] $tpz */
        $tpz = $em->getRepository(Tpz::class)->findBy(array(),array('id'=>'DESC'),1,0);
        if($tpz && $tpz[0]) {
            $user->setTpz($tpz[0]);
        } else {
            throw new NotFoundHttpException('Impossible d\'ajouter un utilisateur car aucun tpz n\'a été trouvé');
        }
        $em->persist($user);
        $em->flush();

        return new Response($data) ;
    }
}