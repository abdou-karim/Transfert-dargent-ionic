<?php
namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use App\Service\Frais;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class TransactionDataPersister implements  ContextAwareDataPersisterInterface
{
    private $security;
    private $compteRepository;
    private $entityManager;
    private $frais;
    private $transactionRepository;

    public function __construct(Security $security,CompteRepository $compteRepository,
                                EntityManagerInterface $entityManager, Frais $frais,
                                TransactionRepository $transactionRepository){
        $this->security = $security;
        $this->compteRepository = $compteRepository;
        $this->entityManager = $entityManager;
        $this->frais = $frais;
        $this->transactionRepository = $transactionRepository;
    }
    public function supports($data, array $context = []): bool
    {
       return $data instanceof Transaction;

    }

    public function persist($data, array $context = [])
    {
      if($context['collection_operation_name'] ==="Recharge_compte"){
          $compte = $data->getCompte();
          $compte->setSolde($compte->getSolde() + $data->getMontant());
          $data->setDateTransfert(new \DateTime('now'));
          $data->setType('depot');
          $data->setUser($this->security->getUser());
          $this->entityManager->persist($data);
          $this->entityManager->persist($compte);
          $this->entityManager->flush();
      }
      if($context['collection_operation_name'] ==="Transfert_client"){
          $frait = $this->frais->getFrais($data->getMontant());
          $parEtat = $frait*0.4;
          $partEntrePrise = $frait*0.3;
          $partAgenceDepot = $frait*0.1;
          $partAgenceRetrait = $frait*0.2;
          if($data->getType() === "depot")
          {
              $agentP=$this->security->getUser()->getAgencePartenaire();

              $comp = $this->compteRepository->getCompte($agentP->getId());
              if($comp->getSolde() >$data->getMontant() ){
                  $comp->setSolde(($comp->getSolde()-$data->getMontant()) + $partAgenceDepot);
                  $data->setPartEtat($parEtat);
                  $data->setCode($this->frais->CreerMatricule($data->getClient()->getNomClient(),$data->getClient()->getNomBeneficiaire()));
                  $data->setPartEntreprise($partEntrePrise);
                  $data->setPartAgenceDepot($partAgenceDepot);
                  $data->setDateTransfert(new \DateTime('now'));
                  $data->setUser($this->security->getUser());
                  $this->entityManager->persist($data);
              }else
              {
                  throw new \RuntimeException("Veuillez Recharger votre compte");
              }

          }
        if($data->getType()==="retrait"){
            $code = $data->getCode();
            $agentP=$this->security->getUser()->getAgencePartenaire();
            $arrayTrans = $this->transactionRepository->findBy(['code'=>$code]);
            if(count($arrayTrans)> 1){
                throw new \RuntimeException("Cet retrait est deja effectué");
            }
            $transaction = $this->transactionRepository->findOneBy(['code'=>$code]);
            $client =  $transaction->getClient();
            $client->setCniBeneficiaire($data->getClient()->getCniBeneficiaire());
            if($code){
               $trans = new Transaction();
               $trans->setUser($this->security->getUser());
               $trans->setCode($code);
               $trans->setMontant($transaction->getMontant());
               $trans->setDateTransfert($transaction->getDateTransfert());
               $trans->setType('retrait');
               $trans->setPartEtat($transaction->getPartEtat());
               $trans->setPartEntreprise($transaction->getPartEntreprise());
               $trans->setPartAgence($partAgenceRetrait);
               $trans->setPartAgenceDepot($transaction->getPartAgenceDepot());
               $trans->setClient($client);
                $comp = $this->compteRepository->getCompte($agentP->getId());
                $comp->setSolde($comp->getSolde() + $transaction->getMontant() + $partAgenceRetrait);
               $trans->setDateDexpiration(new \DateTime('now'));
                $this->entityManager->persist($client);
                $this->entityManager->persist($trans);

            }

        }

          $this->entityManager->flush();
      }


    }

    public function remove($data, array $context = [])
    {
        // TODO: Implement remove() method.
    }
}