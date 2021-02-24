<?php
namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Compte;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CompteDataPersister implements ContextAwareDataPersisterInterface
{
  private $requestStack;
  private $userRepository;
    private $_entityManager;
    public function __construct(RequestStack $requestStack,
                                UserRepository $userRepository,
                                EntityManagerInterface $entityManager){
      $this->requestStack = $requestStack;
      $this->userRepository = $userRepository;
        $this->_entityManager = $entityManager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Compte;
    }

    /**
             *  Une chaîne JWT se compose de 3 parties: l'en-tête et la charge utile encodés base64url,
             * tous deux sont des «objets» JSON, et la signature. Les 3 parties sont séparées par un .
             * Il vous suffit donc de diviser le jeton en ses 3 parties, ici avec explode,
             * puis de décoder les chaînes encodées base64url ( base64_decode) et enfin de décoder le JSON ( json_decode):
     */
    public function persist($data, array $context = [])
    {
        $tokenParts = explode(".", $this->requestStack->getCurrentRequest()->headers->get('authorization'));
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);
       $currentUser= $this->userRepository->findOneBy(['username'=>$jwtPayload->username]);
       $data->setUser($currentUser);
       $data -> setArchivage(false);
       $this->_entityManager->persist($data);
       $this->_entityManager->flush();

    }

    public function remove($data, array $context = [])
    {
        $data -> setArchivage(true);
        $agenP = $data -> getAgencePartenaire();
        $agenP -> setArchivage(true);
        $userAp = $agenP ->getUser();
        foreach ($userAp as $value){
            $value ->setArchivage(true);
            $this->_entityManager->persist($value);
        }
        $this->_entityManager->persist($data);
        $this->_entityManager->persist($agenP);
        $this->_entityManager->flush();
    }
}