<?php
namespace App\Service;

class Frais {
    public function getFrais($montant)
    {
        $max_array = [5000,10000,15000,20000,50000,60000,75000,120000,150000,200000,250000,
                      300000,400000,750000,900000,1000000,1125000,1400000,2000000];

        $frai_array = [425,850,1270,1695,2500,3000,4000,5000,6000,7000,8000,9000,12000,
                       15000,22000,25000,27000,30000,30000];


        for ($i=0;$i<count($max_array);$i++){
            if($montant<=$max_array[$i]){
                return $frai_array[$i];
            }
            if($montant>2000000){
                return $montant*0.02;
            }
        }
    }
    public function CreerMatricule($nom,$prenom,$numCni)
    {

        $num=intval(uniqid(rand(100,999)));
        $dernier=strlen($prenom);
        $numC = strlen($numCni)-2;
        $avantDernier=$dernier-2;
        $cc=substr( $nom, 0,2);
        $ll=substr($prenom,$avantDernier,$dernier);

        return date('Y').strtoupper($cc).strtoupper($ll).$num.$numC;
    }
}