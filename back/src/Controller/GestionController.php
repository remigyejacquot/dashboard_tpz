<?php

namespace App\Controller;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Agency;
use App\Entity\Tpz;
use App\Entity\TpzRoles;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

        $data = [
           'agenciesDev' => $agenciesDev,
           'agenciesCom' => $agenciesCom,
           'users' => $users
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

    /**
     * @Route("/gestion/getEtudiants/{tpzId}", name="get_etudiant_tpz")
     */
    public function getEtudiantsTPz(EntityManagerInterface $entityManager, SerializerInterface $serializer, int $tpzId) {
        /** @var Tpz $tpz */
        $tpz = $entityManager->getRepository(Tpz::class)->find($tpzId);
        if($tpz) {
           return new Response($serializer->serialize($tpz->getUsers(), 'json'));
        }
        return null;
    }

    /**
     * @Route("/gestion/getTeachers", name="get_all_teachers")
     */
    public function getAllTeachers(EntityManagerInterface $entityManager, SerializerInterface $serializer) {
        $users = $entityManager->getRepository(User::class)->findBy(['tpz'=>null]);
        if($users) {
            return new Response($serializer->serialize($users, 'json'));
        }
        return null;
    }

    /**
     * @Route("/gestion/updateRoleBureau/{tpzId}", name="update_role_bureau")
     */
    public function updateRoleBureau(EntityManagerInterface $entityManager, UserRepository $userRepository, Request $request, int $tpzId) {
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        $bureauMembers = $data['data'];

        foreach ($bureauMembers as $bureau) {
            /** @var TpzRoles $roleField */
            $roleField = $entityManager->getRepository(TpzRoles::class)->findOneBy(array('role' => $bureau[0]));
            /** @var User $user */
            $user = $entityManager->getRepository(User::class)->find($bureau[1]);

            $bureauActuel = $userRepository->getUsersBureau($tpzId);
            if($roleField && $user) {
                /** @var User $actuelMember */
                foreach ($bureauActuel as $actuelMember) {
                    if ($actuelMember->getTpzRole()->contains($roleField) && $actuelMember !== $user) {
                        $roleField->removeUser($actuelMember);
                        $actuelMember->removeTpzRole($roleField);
                        $entityManager->persist($actuelMember);
                    }
                }
                $user->addTpzRole($roleField);
                $roleField->addUser($user);
                $entityManager->persist($roleField);
                $entityManager->persist($user);
            }
        }
        $entityManager->flush();

        return new Response('ok');
    }

    /**
     * @Route("/gestion/getMembresBureau/{tpzId}", name="get_membre_bureau")
     */
    public function getMembresBureau(UserRepository $userRepository, SerializerInterface $serializer, int $tpzId) {
        $membres = $userRepository->getUsersBureau($tpzId);
        return new Response($serializer->serialize($membres, 'json'));
    }

     /**
     * @Route("/gestion/addStudent", name="add_student")
     */
    public function addStudent(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request) {
        $data=json_decode($request->getContent());
        $plaintextPassword = 'azerty';
        /** @var User $user */
        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );

        switch ($data){
            case empty($data->lastname) :
                return new Response('Le nom n\'est pas correctement renseigné');
            case empty($data->firstname) :
                return new Response('Le prénom n\'est pas correctement renseigné');
            case empty($data->email) :
                return new Response('L\'email n\'est pas correctement renseigné');
        }

        $user->setEmail($data->email);
        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $user->setIsDev($data->isDev);
        $user->setTpz($entityManager->getRepository(Tpz::class)->find($data->tpz));
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('ok');
    }

    /**
     * @Route("/gestion/updateStudent/{id}", name="update_student")
     */
    public function updateStudent(EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request, int $id) {
        $data=json_decode($request->getContent());
        $user = $entityManager->getRepository(User::class)->find($id);

        switch ($data){
            case empty($data->lastname) :
                return new Response('Le nom n\'est pas correctement renseigné');
            case empty($data->firstname) :
                return new Response('Le prénom n\'est pas correctement renseigné');
            case empty($data->email) :
                return new Response('L\'email n\'est pas correctement renseigné');
        }

        $user->setEmail($data->email);
        $user->setFirstname($data->firstname);
        $user->setLastname($data->lastname);
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('ok');
    }

    /**
     * @Route("/gestion/addTeacher", name="add_teacher")
     */
    public function addTeacher(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, SerializerInterface $serializer, Request $request) {
        $data=json_decode($request->getContent());
        $roles=$data->senderRoles;
        $teacher=$data->teacherToAdd;
        if(in_array('ROLE_ADMIN', $roles)){
            $plaintextPassword = 'azerty';
            /** @var User $user */
            $user = new User();
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            switch ($teacher) {
                case empty($teacher->lastname) :
                    return new Response('Le nom n\'est pas correctement renseigné');
                case empty($teacher->firstname) :
                    return new Response('Le prénom n\'est pas correctement renseigné');
                case empty($teacher->email) :
                    return new Response('L\'email n\'est pas correctement renseigné');
            }

            $user->setEmail($teacher->email);
            $user->setFirstname($teacher->firstname);
            $user->setLastname($teacher->lastname);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
            $user->setIsDev(null);
            $user->setTpz(null);
            $entityManager->persist($user);
            $entityManager->flush();
            return new Response('ok');
        } else
        {
            return new Response('Vous n\'avez pas les autorisations nécessaires pour réaliser cette opération', 403);
        }
    }
}
