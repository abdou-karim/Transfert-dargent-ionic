<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\TransactionBloquer;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Transaction;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionController extends AbstractController
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Security
     */
    private $security;

    public function __construct(TransactionRepository $transactionRepository,
                                EntityManagerInterface $entityManager,Security $security){

        $this->transactionRepository = $transactionRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }
    /**
     * @Route(
     *    path="/api/transaction/code",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\TransactionController::getTransactionByCode",
     *          "__api_resource_class"=Transaction::class,
     *          "__api_item_operation_name"="get_trans_by_code"
     * }
     * )
     */
    public function getTransactionByCode(Request $request,SerializerInterface $serializer): Response
    {
        $requ = json_decode($request->getContent(), true);
      $trans =  $this->transactionRepository->findOneBy(['code'=>$requ['code']]);
      if($trans){

          $trans=$serializer->normalize($trans, 'json',['groups' => 'getTrans']);
          return new JsonResponse($trans, Response::HTTP_OK);

      }
      else{
          return new JsonResponse('Cette transaction n\'existe pas',Response::HTTP_INTERNAL_SERVER_ERROR);
      }


    }


    /**
     * @Route(
     *    path="/api/transaction/bloquer",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\TransactionController::bloqueTransaction",
     *          "__api_resource_class"=Transaction::class,
     *          "__api_item_operation_name"="bloquer_transaction"
     * }
     * )
     */
    public function bloqueTransaction(Request $request,SerializerInterface $serializer){
        $requ = json_decode($request->getContent(), true);
        $arrayTrans =  $this->transactionRepository->findBy(['code'=>$requ['code']]);
           if(count($arrayTrans)>1){
               return new JsonResponse('Cette transaction est deja retirée !',Response::HTTP_BAD_REQUEST);
           }
        $trans = $this->transactionRepository->findOneBy(['code'=>$requ['code']]);
           $transBloquer = new TransactionBloquer();
           $clientTrans = $trans->getClient();
           $client = new Client();
           $client->setNomClient($clientTrans->getNomClient())
                    ->setNumeroClient($clientTrans->getNumeroClient())
                    ->setNomBeneficiaire($clientTrans->getNomBeneficiaire())
                    ->setNumeroBeneficiaire($clientTrans->getNumeroBeneficiaire());
           $transBloquer->setCode($trans->getCode())
                        ->setMontant($trans->getMontant())
                        ->setType($trans->getType())
                        ->setClient($client)
                        ->setUser($trans->getUser())
                        ->setDateTransfert($trans->getDateTransfert());
           $this->entityManager->persist($transBloquer);
           $this->entityManager->persist($client);
           $this->entityManager->remove($trans);
           $this->entityManager->flush();
           return new JsonResponse('succes',Response::HTTP_OK);
        }
}
