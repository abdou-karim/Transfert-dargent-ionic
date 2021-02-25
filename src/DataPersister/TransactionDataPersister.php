<?php
namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TransactionDataPersister implements  ContextAwareDataPersisterInterface
{
    private $security;
    private $compteRepository;
    private $entityManager;

    public function __construct(Security $security,CompteRepository $compteRepository,  EntityManagerInterface $entityManager){
        $this->security = $security;
        $this->compteRepository = $compteRepository;
        $this->entityManager = $entityManager;
    }
    public function supports($data, array $context = []): bool
    {
       return $data instanceof Transaction;

    }

    public function persist($data, array $context = [])
    {
      if($context['collection_operation_name'] ==="Recharge_compte"){
          $compte = $data->getCompte();
          $compte->setSolde($data->getMontant());
          $data->setUser($this->security->getUser());
          $this->entityManager->persist($data);
          $this->entityManager->persist($compte);
          $this->entityManager->flush();
      }
      if($context['collection_operation_name'] ==="Transfert_client"){
          $data->setUser($this->security->getUser());
          $this->entityManager->persist($data);
          $this->entityManager->flush();
      }
    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}