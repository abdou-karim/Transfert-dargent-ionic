<?php
namespace App\DataFixtures;
use App\Entity\AgencePartenaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AgencePartenaireFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceAgencePKey($i){
        return sprintf('agence_partenaire_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        $tabAgencePartenaire = ['Basse_Service','Sidibe_Service','Fatou_Service','Rangba_Service','Samba_Service'];
        for($o=0;$o<25;$o++){
            $tabAdAg [] = $this->getReference(UserFixtures::getReferenceAdminAgenceKey($o% 5));
            $tabUAg [] = $this->getReference(UserFixtures::getReferenceUtilisateurAgenceKey($o%25));
        }
        for ($i = 0;$i<5;$i++){
            $agencePartenaire = new AgencePartenaire();
            $agencePartenaire ->setNom($tabAgencePartenaire[$i])
                ->setEmail($fake->email)
                ->setTelephone($fake->phoneNumber)
                ->setAdresse($fake -> address);
            foreach ($tabAgencePartenaire as $value){
                $agencePartenaire ->addUser($fake->unique(true)->randomElement($tabAdAg));
                $agencePartenaire ->addUser($fake->unique(true)->randomElement($tabUAg));
            }
            $manager->persist($agencePartenaire);
            $this->addReference(self::getReferenceAgencePKey($i),$agencePartenaire);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}