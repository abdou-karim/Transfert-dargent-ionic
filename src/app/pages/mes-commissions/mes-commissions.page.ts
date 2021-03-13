import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';

@Component({
  selector: 'app-mes-commissions',
  templateUrl: './mes-commissions.page.html',
  styleUrls: ['./mes-commissions.page.scss'],
})
export class MesCommissionsPage implements OnInit {
transaction: Transaction[] = [];
  tabMontantTotal: number[] = [];
  MontantTotal: number;
  constructor(private trans: TransService) { }

  ngOnInit() {
    this.getMesComission()
  }

  getMesComission(){
    return this.trans.getToutMesCommissions()
      .subscribe(
        data => {
          this.transaction =data['hydra:member']
          for (const oneTrnas of this.transaction) {
            this.tabMontantTotal.push(Number(oneTrnas.partAgenceDepot));
            this.tabMontantTotal.push(Number(oneTrnas.partAgenceRetrait));
            this.MontantTotal = this.tabMontantTotal.reduce(this.addValue);
          }
        }
      )
  }
  addValue(a,b){
    return a + b;
  }
}
