<?php
namespace App\DataFixtures;
use App\Entity\Compte;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CompteFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        for ($i= 0 ;$i < 2; $i ++){
            $tabAgencePartenaire[] = $this->getReference(AgencePartenaireFixtures::getReferenceAgencePKey($i% 2));
            $tabAdminsysteme [] = $this->getReference(UserFixtures::getReferenceAdminSystemeKey($i%2));
        }
        $tabNumeroCompte = ['6037f4cf79f4b3.78291468','48397157.60393a9f6f9422'];
        $tabSolde = ['10000000','500000'];

        for ($a = 0 ;$a <2 ;$a ++){
            $compte = new Compte();
            $compte->setNumeroCompte($tabNumeroCompte[$a])
                ->setDateCreationCompte(new \DateTime('now'))
                ->setSolde($tabSolde[$a])
                ->setArchivage(false);
            foreach ($tabNumeroCompte as $value){
                $compte->setUser($fake->unique(true)->randomElement($tabAdminsysteme));
                $compte->setAgencePartenaire($fake->unique(true)->randomElement($tabAgencePartenaire));
            }
            $manager->persist($compte);
            $manager->flush();
        }

    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            AgencePartenaireFixtures::class
        );
    }
}
