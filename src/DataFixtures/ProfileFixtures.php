<?php
namespace App\DataFixtures;
use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture
{
    public static function getReferenceKey($i){
        return sprintf('profil_user_%s',$i);
    }
    public function load(ObjectManager $manager)
    {
        $libelles=['AdminSysteme',"AdminAgence","Caissier","UtilisateurAgence"];

      for($i = 0 ; $i <=3;$i++){
          $profil = new Profile();
          $profil -> setLibelle($libelles[$i])

              ->setArchivage(false);
          $manager->persist($profil);
          $this->addReference(self::getReferenceKey($i),$profil);
      }
      $manager->flush();
    }
}