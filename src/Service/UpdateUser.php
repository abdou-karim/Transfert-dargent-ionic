<?php
namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class UpdateUser
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;
    private $addUser;

    public function __construct(
        UserPasswordEncoderInterface $encoder,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserRepository $userRepository,
        AddUser $addUser

    )
    {
        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->addUser=$addUser;
        $this->userReposirory=$userRepository;
    }
    public function ModifierUser(Request $request,int $id){

        $user=$this->userReposirory->find($id);
        $requestAll = $request->request->all();
       foreach ( $requestAll as  $key=>$value){

            if($key !=="_method" || !$value){

                $user->{"set".ucfirst($key)}($value);
                $this->em->persist($user);
                $errors = $this->validator->validate($user);
                if (count($errors)){
                    $errors = $this->serializer->serialize($errors,"json");
                    return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
                }
                $this->em->flush();
            }
        }
        $photo=$request->files->get('photo');


        if($photo){
            $photoBlob = fopen($photo->getRealPath(),"rb");
            $user->setAvatar($photoBlob);
            $this->em->persist($user);

            $errors = $this->validator->validate($user);
            if (count($errors)){
                $errors = $this->serializer->serialize($errors,"json");
                return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
            }
        }
       return new JsonResponse('Succes',Response::HTTP_OK);
    }

}
