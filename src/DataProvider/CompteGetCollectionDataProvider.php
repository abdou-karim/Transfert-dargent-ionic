<?php
namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Compte;
use App\Repository\CompteRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;


class CompteGetCollectionDataProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
    private $compteRepo;
    private $security;
    public function __construct(CompteRepository $compteRepository, Security $security){
        $this->compteRepo = $compteRepository;
        $this->security = $security;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        if($operationName === "adminAgence_compte"){
            return Compte::class === $resourceClass;
        }
        else{
            return  false;
        }
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {

        if($operationName ==="adminAgence_compte"){

            $compte = $this->compteRepo->getCompte($this->security->getUser()->getAgencePartenaire()->getId());
            return $compte;
        }
    }

}