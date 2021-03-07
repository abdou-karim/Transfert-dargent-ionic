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
  constructor(private transaction: TransService) { }

  ngOnInit() {
    this.getToutMesCommissions();
  }

  getToutMesCommissions(){
    return this.transaction.getToutMesCommissions()
      .subscribe(
        (data => {
          this.trans = data['hydra:member'];
          console.log(this.trans);
        })
      );
  }
}
