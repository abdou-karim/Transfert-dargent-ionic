import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';
import {AlertController} from '@ionic/angular';

@Component({
  selector: 'app-retrait',
  templateUrl: './retrait.page.html',
  styleUrls: ['./retrait.page.scss'],
})
export class RetraitPage implements OnInit {
  transaction: Transaction;
  constructor(private transS: TransService, private alertController: AlertController) { }

  ngOnInit() {
  }
  getCode(code:string){
    if(code === ""){
      return ;
    }
    this.transS.getTransactionByCode({code: code})
      .subscribe(
        (data) => {
          // @ts-ignore
          this.transaction = data;
          console.log(data);
        },
        async () => {
          // @ts-ignore
          this.transaction = "";
          const erreurCode = await this.alertController.create({
            header: 'Erreur Code',
            subHeader: 'INFOS',
            cssClass: 'basic-alert',
            mode:'ios',
            message: 'Ce code n\'existe pas .! </p><ion-icon name="alert-circle-outline" [color]="#e04055"></ion-icon>'
          });
          await erreurCode.present();
        }
      )
  }
}
