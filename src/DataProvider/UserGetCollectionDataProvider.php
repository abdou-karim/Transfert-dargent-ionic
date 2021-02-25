<?php
namespace App\DataProvider;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserGetCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    private $userRepository;
    private $paginationExtension;
    private $managerRegistry;
    public function __construct(UserRepository $userRepository, PaginationExtension $paginationExtension,ManagerRegistry $managerRegistry)
    {
        $this->userRepository = $userRepository;
        $this->managerRegistry = $managerRegistry;
        $this->paginationExtension=$paginationExtension;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if ($operationName==="get_Caissier" || $operationName==="get_userAgence"){

            return User::class === $resourceClass;
        }else{
            return false;
        }
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
       if($operationName==="get_Caissier"){
           $manager = $this->managerRegistry->getManagerForClass($resourceClass);
           $repository = $manager->getRepository($resourceClass);
           $userRepo = $repository->getUsersSpeciale('Caissier');
           $this->paginationExtension->applyToCollection($userRepo, new QueryNameGenerator(), $resourceClass, $operationName,$context);
           if($userRepo !== null){

               return $userRepo->getQuery()->getResult();
           }
       }
       if($operationName ==="get_userAgence"){
           $manager = $this->managerRegistry->getManagerForClass($resourceClass);
           $repository = $manager->getRepository($resourceClass);
           $userRepo = $repository->getUsersSpeciale('UtilisateurAgence');
           $this->paginationExtension->applyToCollection($userRepo, new QueryNameGenerator(), $resourceClass, $operationName,$context);
           if($userRepo !== null){

               return $userRepo->getQuery()->getResult();
           }
       }
    }
}