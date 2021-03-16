<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\AddUser;
use App\Service\UpdateUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private $updateUser;
    private $addUser;
    private $security;
    private $userRepository;
    public function __construct(
        AddUser $addUser,Security $security,UpdateUser $updateUser,UserRepository $userRepository


    )
    {

        $this->addUser=$addUser;
        $this->security = $security;
        $this->updateUser=$updateUser;
        $this->userRepository=$userRepository;
    }
    /**
     * @Route(
     *     path="/api/adminSysteme/caissier",
     *      name="caissier_post",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::addUser",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="post_Caissier"
     * }
     * )
     */
    public function addUser(Request $request): Response
    {
        if($this->security->getUser()->getRoles()[0] === "ROLE_AdminSysteme"){

            return $this->addUser->addUser($request,'Caissier');
        }else{
            return new JsonResponse('Seul les adminSysteme sont autorise !',500);
        }

    }

    /**
     *  * @Route(
     *     path="/api/adminSysteme/caissier/{id}",
     *      name="caissier_put",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::updateUser",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="put_caissier"
     * }
     * )
     */
    public function updateUser(Request $request,int $id){
        $user = $this->userRepository->findOneBy(['id'=>$id]);
        if($this->security->getUser()->getRoles()[0] === "ROLE_AdminSysteme" && $user->getProfile()->getLibelle() ==="Caissier")
        {
            return $this->updateUser->ModifierUser($request,$id);
        }
        else{
            return new JsonResponse('Seul les adminSysteme sont autorise !',500);
        }
    }
    /**
     * @Route(
     *     path="/api/adminAgence/userAgence",
     *      name="userAgence_post",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::addUser",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="post_userAgence"
     * }
     * )
     */
    public function addUserAgence(Request $request): Response{
        if($this->security->getUser()->getRoles()[0] === "ROLE_AdminAgence"){

            return $this->addUser->addUser($request,'UtilisateurAgence',$request->request->get('username'));
        }else{
            return new JsonResponse('Seul les adminAgence sont autorise !',500);
        }
    }

    /**
     *  * @Route(
     *     path="/api/adminAgence/userAgence/{id}",
     *      name="userAgence_put",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::updateUserAgence",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="put_userAgence"
     * }
     * )
     */
    public function updateUserAgence(Request $request,int $id){
        $user = $this->userRepository->findOneBy(['id'=>$id]);
     /*   if($this->security->getUser()->getRoles()[0] === "ROLE_AdminAgence" && $user->getProfile()->getLibelle() ==="UtilisateurAgence")
        {
            return $this->updateUser->ModifierUser($request,$id);
        }
        else{
            return new JsonResponse('Seul les adminAgence sont autorise !',500);
        }*/
    }

    /**
     * @Route (
     *     path="/api/log/username",
     *     methods={"PUT"},
     *
     * )
     */
   public function getAllProfilByConnection(Request $request)
    {
        $requ = json_decode($request->getContent(),true);
     $user=$this->userRepository->getAllProfileUser($requ['username']);
     $profile = $user->getProfiles();
     if(count($profile) > 1)
     {
         return $this->json($user);
     }
    }
}
