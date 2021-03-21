import { Component, OnInit } from '@angular/core';
import {TransService} from '../../_services/transactions/trans.service';
import {Transaction} from '../../_modeles/transaction';
import {AlertController} from '@ionic/angular';

@Component({
  selector: 'app-transaction-encours',
  templateUrl: './transaction-encours.page.html',
  styleUrls: ['./transaction-encours.page.scss'],
})
export class TransactionEncoursPage implements OnInit {
  transactions: Transaction[] = [];

  constructor(private tService: TransService, private alerteCont: AlertController) {
  }

  ngOnInit() {
    this.getTransactionEnCours();
  }

  getTransactionEnCours() {
    this.tService.getTransactionEnCours()
      .subscribe(
        data => {
          this.transactions = data['hydra:member'];
        }
      );
  }

  async annuler(code: string) {
    const alert = await this.alerteCont.create({
      header: 'Confirmation',
      cssClass: 'basic-alert',
      mode: 'ios',
      message: 'Voulez vous annuler la transaction <br><ion-icon name="alert-circle-outline"></ion-icon>',
      buttons: [
        {
          text: 'annuler'
        },
        {
          text: 'Confirmer',
          cssClass: 'confirm',
          handler: () => {
            return this.tService.bloquerTransaction({code})
              .subscribe(
                async () => {
                  const tranReussi = await this.alerteCont.create({
                    header: 'Bloquer transaction',
                    subHeader: 'INFOS',
                    cssClass: 'basic-alert',
                    mode: 'ios',
                    message: 'Votre transaction a ete bloquée avec succes' + '<br> <ion-icon name="checkmark-done-outline"></ion-icon>'
                  });
                  this.getTransactionEnCours();
                  await tranReussi.present();
                }
              );
          }
        }
      ]

    });
    await alert.present();
  }
}
