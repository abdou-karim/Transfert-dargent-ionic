import { Component, OnInit } from '@angular/core';
import {FraisService} from '../../../_services/calculFaris/frais.service';

@Component({
  selector: 'app-emetteur',
  templateUrl: './emetteur.component.html',
  styleUrls: ['./emetteur.component.scss'],
})
export class EmetteurComponent implements OnInit {
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
