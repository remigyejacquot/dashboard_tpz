<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Agency;
use App\Entity\Tpz;
use App\Entity\TpzRoles;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GestionController extends AbstractController
{
    /**
     * @Route("/gestion/groupes/{tpzId}", name="gestion_groupes")
     */
    public function gestionGroupes(EntityManagerInterface $entityManager, SerializerInterface $serializer, int $tpzId) {
        $agenciesDev = $entityManager->getRepository(Agency::class)->findBy(array('tpz' => $tpzId, 'is_dev' => true));
        $agenciesCom = $entityManager->getRepository(Agency::class)->findBy(array('tpz' => $tpzId, 'is_dev' => false));
        /** @var Tpz $tpz */
        $tpz = $entityManager->getRepository(Tpz::class)->find($tpzId);
        $users = [];
        if($tpz) {
            $users = $tpz->getUsers();
        }

        $usersData = [];
        /** @var User $user */
        foreach ($users as $user) {
            $data = array('nom' => $user->getLastname(), 'prenom' => $user->getFirstname(), 'id' => $user->getId());
            $usersData[] = $data;
        }

        $data = [
           'agenciesDev' => $agenciesDev,
           'agenciesCom' => $agenciesCom,
           'users' => $usersData
        ];

        return New Response($serializer->serialize($data, 'json'));

    }

    /**
     * @Route("/gestion/updateRole", name="update_role")
     */
    public function updateRole(EntityManagerInterface $entityManager, Request $request) {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        $role = $data['roleUser'];
        $idUser = $data['idUser'];
        $idAgence = $data['idAgence'];

        /** @var TpzRoles $roleField */
        $roleField = $entityManager->getRepository(TpzRoles::class)->findOneBy(array('role' => $role));
        /** @var User $user */
        $user = $entityManager->getRepository(User::class)->find($idUser);
        /** @var Agency $agency */
        $agency = $entityManager->getRepository(Agency::class)->find($idAgence);

        if($roleField) {
            $user->addTpzRole($roleField);
            $user->setAgency($agency);
            $roleField->addUser($user);
        }
        $entityManager->persist($roleField);
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('ok');
    }

    /**
     * @Route("/gestion/deleteGroupMembers/{id}", name="delete_group_members")
     */
    public function deleteGroupMembers(EntityManagerInterface $entityManager, int $id) {
        /** @var Agency $agency */
        $agency = $entityManager->getRepository(Agency::class)->find($id);
        $members = $agency->getUsers();
        /** @var TpzRoles $role */
        $role = $entityManager->getRepository(TpzRoles::class)->findOneBy(array('role' => 'chef de projet'));
        /** @var User $member */
        foreach ($members as $member) {
            if($member->getTpzRole()->contains($role)) {
                $member->getTpzRole()->removeElement($role);
                $entityManager->persist($member);
            }
            $agency->removeUser($member);
        }
        $entityManager->persist($agency);
        $entityManager->flush();
        return new Response('ok');
    }

}