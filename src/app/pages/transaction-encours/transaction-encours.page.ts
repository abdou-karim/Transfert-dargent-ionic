import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';

@Component({
  selector: 'app-transaction-encours',
  templateUrl: './transaction-encours.page.html',
  styleUrls: ['./transaction-encours.page.scss'],
})
export class TransactionEncoursPage implements OnInit {
   transactions: Transaction[] = [];
  constructor(private tService: TransService) { }

  ngOnInit() {
    this.getTransactionEnCours();
  }
  getTransactionEnCours()
  {
    this.tService.getTransactionEnCours()
      .subscribe(
        data => {
          this.transactions = data['hydra:member'];
        }
      );
  }
}
