<?php
namespace App\Service;

use ApiPlatform\Core\Api\IriConverterInterface;
use App\Repository\ProfileRepository;
use App\Repository\ProfilsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AddUser
{
    private $encoder;
    private $serializer;
    private $validator;
    private $em;
    private $request;
    private $security;
    private $profileRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(

                                UserPasswordEncoderInterface $encoder,
                                SerializerInterface $serializer,
                                ValidatorInterface $validator,
                                EntityManagerInterface $em,
                                ProfileRepository $profileRepository,
                                UserRepository $userRepository

)
{

        $this->encoder=$encoder;
        $this->serializer=$serializer;
        $this->validator=$validator;
        $this->em=$em;
        $this->profileRepository=$profileRepository;
    $this->userRepository = $userRepository;
}

    public function addUser(Request $request,$profile,$userByUsername=null)
    {
         $user = $request->request->all();
        $photo = $request->files->get("avatar");
        $user = $this->serializer->denormalize($user, "App\Entity\User", true);
        $profile = $this->profileRepository->findOneBy(['libelle'=>$profile]);
        $userByUsername = $this->userRepository->findOneBy(['username'=>$userByUsername]);
            if ($photo) {
                $photoBlob = fopen($photo->getRealPath(), "rb");
                $user->setAvatar($photoBlob);
            }
            $errors = $this->validator->validate($user);
            if (count($errors)) {
                $errors = $this->serializer->serialize($errors, "json");
                return new JsonResponse($errors, Response::HTTP_BAD_REQUEST, [], true);
            }

//            $password = $user->getPlainPassword();
            $password = 'Sidibe123';
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->addProfile($profile);
            $user->setArchivage(false);
            if ($this->encoder->encodePassword($user, $password)) {

                $this->em->persist($user);
                $this->em->flush();

                return new JsonResponse('Authenticated', Response::HTTP_OK);

            } else {

                return new JsonResponse(' username or password not work', Response::HTTP_INTERNAL_SERVER_ERROR);
            }


        }
}
