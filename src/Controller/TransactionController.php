<?php

namespace App\Controller;

use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Transaction;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionController extends AbstractController
{
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository){

        $this->transactionRepository = $transactionRepository;
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
}
