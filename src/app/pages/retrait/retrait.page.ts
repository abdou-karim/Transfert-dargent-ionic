import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';

@Component({
  selector: 'app-retrait',
  templateUrl: './retrait.page.html',
  styleUrls: ['./retrait.page.scss'],
})
export class RetraitPage implements OnInit {
  transaction: Transaction;
  constructor(private transS: TransService) { }

  ngOnInit() {
  }
  getCode(code:string){
    return this.transS.getTransactionByCode({code: code})
      .subscribe(
        (data) => {
          // @ts-ignore
          this.transaction = data;
          console.log(data);
        },
      () => {
          alert('cette transcation n\'existe pas');
      }
      )
  }
}
