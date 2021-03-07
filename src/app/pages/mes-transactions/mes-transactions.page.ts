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

  constructor(private trans: TransService) { }

  ngOnInit() {
    this.getMestransaction();
  }

  getMestransaction(){
    return this.trans.getMesTranscation()
      .subscribe(
        (data) => {
         this.transaction = data['hydra:member'];
        }
      );
  }
}
