<?php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 */
class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {

        if($context['item_operation_name'] === "delete_caissier"){
            $profile = $data->getProfile();
            if($profile->getLibelle() === "Caissier"){
                $data->setArchivage(true);
                $this->_entityManager->flush();
            }
            else{
                throw new \RuntimeException("Vous ne pouvez supprimer qu'un Caissier");
            }

        }
        if($context['item_operation_name'] ==="delete_userAgence" ){

            $profile = $data->getProfile();
            if($profile->getLibelle() === "UtilisateurAgence"){
                $data->setArchivage(true);
                $this->_entityManager->flush();
            }
            else{
                throw new \RuntimeException("Vous ne pouvez supprimer qu'un Utilisateur Agence");
            }
        }
    }
}