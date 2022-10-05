<?php
namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Transaction;
use App\Repository\CompteRepository;
use App\Repository\TransactionRepository;
use App\Service\Frais;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twilio\Rest\Client;

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
          if($data->getType() === "depot")
          {
              $agentP=$this->security->getUser()->getAgencePartenaire();
                $id='ACe19e886fe45f28a8d1cf2b134eb2a306';
                $token='f25dc0376f3f6e765ac72fa49917161f';
                $code = $this->frais->CreerMatricule($data->getClient()->getNomClient(),$data->getClient()->getNomBeneficiaire());
              $twilio = new Client($id, $token);
              $comp = $this->compteRepository->getCompte($agentP->getId());
              if($comp->getSolde() >$data->getMontant() ){
                  $totalMontantDepot = $data->getMontant() + $frait;
                  $comp->setSolde(($comp->getSolde()-$totalMontantDepot) + $partAgenceDepot);
                  $data->setPartEtat($parEtat);
                  $data->setCode($code);
                  $data->setPartEntreprise($partEntrePrise);
                  $data->setPartAgenceDepot($partAgenceDepot);
                  $data->setDateTransfert(new \DateTime('now'));
                  $data->setStatut('encours');
                  $data->setUser($this->security->getUser());
                  $twilio->messages->create(
                      '221771659895',
                      [
                          'from'=> '18647546221',
                          'body' => 'Vous avez recu un transfer de '.$data->getMontant().' de '.$data->getClient()->getNomClient().' '
                              .$data->getClient()->getNumeroClient().'RDV chez un agent Money Sa pour retirer votre argent. Votre code de retrait est :'.$code
                      ]
                  );
              /*    $twilio->messages
                      ->create("whatsapp:+221771659895", // to
                          array(
                              "from" => "whatsapp:+14155238886",
                              "body" => "Your appointment is coming up on July 21 at 3PM"
                          )
                      );*/
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
               $transaction->setStatut('retirer');
               $trans->setUser($this->security->getUser());
               $trans->setCode($code);
               $trans->setMontant($transaction->getMontant());
               $trans->setDateTransfert($transaction->getDateTransfert());
               $trans->setType('retrait');
               $trans->setStatut('retirer');
               $trans->setPartEtat($transaction->getPartEtat());
               $trans->setPartEntreprise($transaction->getPartEntreprise());
               $trans->setPartAgenceRetrait($transaction->getPartAgenceDepot()*2);
               $trans->setPartAgenceDepot($transaction->getPartAgenceDepot());
               $trans->setClient($client);
                $comp = $this->compteRepository->getCompte($agentP->getId());
                $comp->setSolde($comp->getSolde() + $transaction->getMontant() + $transaction->getPartAgenceDepot()*2);
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
