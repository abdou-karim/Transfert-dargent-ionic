import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';

@Component({
  selector: 'app-mes-transactions',
  templateUrl: './mes-transactions.page.html',
  styleUrls: ['./mes-transactions.page.scss'],
})
export class MesTransactionsPage implements OnInit {
  transaction: Transaction[] = [];
  tabMontantTotal: number[] = [];
  MontantTotal: number;

  constructor(private trans: TransService) { }

  ngOnInit() {
    this.getMestransaction();
  }

  getMestransaction(){
    return this.trans.getMesTranscation()
      .subscribe(
        (data) => {
         this.transaction = data['hydra:member'];
          for (const oneTrnas of this.transaction) {
            this.tabMontantTotal.push(Number(oneTrnas.montant));
            this.MontantTotal = this.tabMontantTotal.reduce(this.addValue);
          }
        }
      );
  }
  addValue(a,b){
    return a + b;
  }
}
