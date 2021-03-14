<?php
namespace App\DataProvider;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGenerator;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\PaginationExtension;

class TransactionGetCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;
    /**
     * @var PaginationExtension
     */
    private $paginationExtension;

    public function __construct(Security $security, TransactionRepository $transactionRepository,
                                ManagerRegistry $managerRegistry,PaginationExtension $paginationExtension){
        $this->security = $security;
        $this->transactionRepository = $transactionRepository;
        $this->managerRegistry = $managerRegistry;
        $this->paginationExtension = $paginationExtension;
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName === "get_transaction_commision_agencePartenaire" || $operationName === "get_commision_utilisateurAgence")
        {
            return Transaction::class === $resourceClass;
        }
        else{
            return false;
        }
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        if($operationName === "get_transaction_commision_agencePartenaire"){
            $AdminAgence = $this->security->getUser();
            $idAgence =  $AdminAgence->getAgencePartenaire()->getId();
           // $manager = $this->managerRegistry->getManagerForClass($resourceClass);
            //$repository = $manager->getRepository($resourceClass);
           // $Mestransaction = $repository->getCommissionAgencePartenaire($idAgence);
            $Mestransaction = $this->transactionRepository->getCommissionAgencePartenaire($idAgence);
            //$this->paginationExtension->applyToCollection($Mestransaction, new QueryNameGenerator(), $resourceClass, $operationName,$context);
         /*   if($Mestransaction !== null){


                return $Mestransaction->getQuery()->getResult();
            }*/
            return $Mestransaction;
        }
        if($operationName === "get_commision_utilisateurAgence")
        {
            $userAgence = $this->security->getUser();
            $mesCommision = $this->transactionRepository->getCommissionUserAgence($userAgence->getId());
           return  $mesCommision;
        }

    }

}