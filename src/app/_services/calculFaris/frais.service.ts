import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class FraisService {
  max_array = [5000,10000,15000,20000,50000,60000,75000,120000,150000,200000,250000,
    300000,400000,750000,900000,1000000,1125000,1400000,2000000];

  frai_array = [425,850,1270,1695,2500,3000,4000,5000,6000,7000,8000,9000,12000,
    15000,22000,25000,27000,30000,30000];
  constructor() { }
  calcalueFraisTransfert(montant:number){
    for (let i=0; i<this.max_array.length;i++){
      if(montant<=this.max_array[i]){
        return this.frai_array[i];
      }
      if(montant>2000000){
        return montant*0.2;
      }
    }
  }
}
