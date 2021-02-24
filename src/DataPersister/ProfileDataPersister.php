<?php
namespace App\DataPersister;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;

class ProfileDataPersister implements ContextAwareDataPersisterInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profile;
    }

    public function persist($data, array $context = [])
    {
        $data->setArchivage(false);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data, array $context = [])
    {
        $data->setArchivage(true);
        $userProfile = $data->getUsers();
        foreach ($userProfile as $user){
            $user->setArchivage(false);
            $this->entityManager->persist($user);
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}