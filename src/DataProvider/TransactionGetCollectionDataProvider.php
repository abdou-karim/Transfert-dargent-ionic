<?php
namespace App\DataProvider;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Symfony\Component\Security\Core\Security;

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

    public function __construct(Security $security, TransactionRepository $transactionRepository){
        $this->security = $security;
        $this->transactionRepository = $transactionRepository;
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
            $Mestransaction = $this->transactionRepository->getCommissionAgencePartenaire($idAgence);
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