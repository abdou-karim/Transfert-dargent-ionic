import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';

@Component({
  selector: 'app-transaction',
  templateUrl: './transaction.page.html',
  styleUrls: ['./transaction.page.scss'],
})
export class TransactionPage implements OnInit {
  trans: Transaction[] = [];

  tabMontantTotal: number[] = [];
  MontantTotal: number;
  constructor(private transaction: TransService) {
  }

  ngOnInit() {
    this.getToutMesCommissions();
  }

  getToutMesCommissions(){
    return this.transaction.getToutMesCommissions()
      .subscribe(
        ((data) => {
          this.trans = data['hydra:member'];
          for (const oneTrnas of this.trans) {
            this.tabMontantTotal.push(Number(oneTrnas.montant));
            this.MontantTotal = this.tabMontantTotal.reduce(this.addValue);
          }
        })
      );
  }
  addValue(a,b){
    return a + b;
  }
}
