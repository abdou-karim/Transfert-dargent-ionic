import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';
import {Platform} from '@ionic/angular';

@Component({
  selector: 'app-mes-transactions',
  templateUrl: './mes-transactions.page.html',
  styleUrls: ['./mes-transactions.page.scss'],
})
export class MesTransactionsPage implements OnInit {
  transaction: Transaction[] = [];
  tabMontantTotal: number[] = [];
  MontantTotal: number;

  constructor(private trans: TransService, private platform: Platform) { }

  ngOnInit() {
    this.getMestransaction();
  }
/*
  getMestransactions(){
    return this.trans.getMesTranscations()
      .subscribe(
        data => {
         this.transaction = data['hydra:member'];
          for (const oneTrnas of this.transaction) {
            this.tabMontantTotal.push(Number(oneTrnas.montant));
            this.MontantTotal = this.tabMontantTotal.reduce(this.addValue);
          }
        }
      );
  }
  // */
  getMestransaction(){
    if (this.platform.is('cordova')) {
      return this.trans.getMesTranscation().then(
        data => {
          console.log(data.data);
        }
      );
    } else {
      return this.trans.getMesTranscations()
        .subscribe(
          data => {
            this.transaction = data['hydra:member'];
            for (const oneTrnas of this.transaction) {
              this.tabMontantTotal.push(Number(oneTrnas.montant));
              this.MontantTotal = this.tabMontantTotal.reduce(this.addValue);
            }
          }
        );
    }
  }
  addValue(a, b){
    return a + b;
  }
}
