<?php
namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getReferenceAdminAgenceKey($i){
        return sprintf('admin_ag_user_%s',$i);
    }
    public static function getReferenceUtilisateurAgenceKey($i){
        return sprintf('utilisateur_agence%s',$i);
    }
    public static function getReferenceAdminSystemeKey($i){
        return sprintf('admin_systeme%s',$i);
    }
    private $encode;

    public function __construct(UserPasswordEncoderInterface $encode)
    {
        $this->encode=$encode;
    }

    public function load(ObjectManager $manager)
    {
        $fake = Factory::create('fr-FR');
        for($i = 0; $i <=3;$i++){
            $userProfil = $this->getReference(ProfileFixtures::getReferenceKey($i%4));
            $nbrUser = 2;
            if($userProfil -> getLibelle() === "AdminAgence"){
                $tabTelephone = ['771656565','771232323'];
            }
            if($userProfil -> getLibelle() === "UtilisateurAgence")
            {
                $tabTelephone = ['761656565','761232323'];
            }
            if($userProfil -> getLibelle() === "Caissier"){
                $tabTelephone = ['701656565','701232323','708888888'];
            }
            if($userProfil -> getLibelle() === "AdminSysteme"){
                $tabTelephone = ['751656565','751232323'];
            }
            for ($u = 0 ;$u <$nbrUser; $u ++){
                $user =  new User();
                $password = $this->encode->encodePassword ($user, 'Sidibe123' );
                $user -> setProfile($userProfil)
                    ->setArchivage(false)
                    ->setEmail($fake -> email)
                    ->setNom($fake ->name)
                    ->setPrenom($fake -> firstName)
                    ->setUsername($fake->unique()->randomElement($tabTelephone))
                    ->setTelephone($fake -> phoneNumber)
                    ->setPassword($password);
                if($userProfil -> getLibelle() === "AdminAgence"){
                    $this->addReference(self::getReferenceAdminAgenceKey($u),$user);
                }
                if($userProfil -> getLibelle() === "UtilisateurAgence"){
                    $this->addReference(self::getReferenceUtilisateurAgenceKey($u),$user);
                }
                if($userProfil -> getLibelle() === "AdminSysteme"){
                    $this->addReference(self::getReferenceAdminSystemeKey($u),$user);
                }
                $manager->persist($user);
            }

        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ProfileFixtures::class,
        );
    }
}