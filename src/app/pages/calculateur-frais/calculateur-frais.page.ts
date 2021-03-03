import { Component, OnInit } from '@angular/core';
import {FraisService} from '../../_services/calculFaris/frais.service';

@Component({
  selector: 'app-calculateur-frais',
  templateUrl: './calculateur-frais.page.html',
  styleUrls: ['./calculateur-frais.page.scss'],
})
export class CalculateurFraisPage implements OnInit {

  frais: number;
  Total: number;
  constructor(private fraisS: FraisService) { }

  ngOnInit() {}

  getFrais( montant: number){
    montant = Number(montant)
    if(montant <500){
      this.frais = 0;
      this.Total = 0;
    }else {
      this.frais = this.fraisS.calcalueFraisTransfert(montant);
      this.Total = montant + this.frais;
    }


  }

}
