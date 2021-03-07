import { Component, OnInit } from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {TransService} from '../../_services/transactions/trans.service';
import {AlertController} from '@ionic/angular';
import {Transaction} from '../../_modeles/transaction';

@Component({
  selector: 'app-bloquer-transaction',
  templateUrl: './bloquer-transaction.page.html',
  styleUrls: ['./bloquer-transaction.page.scss'],
})
export class BloquerTransactionPage implements OnInit {
  bloquerTransaction: FormGroup;
  transaction: Transaction;
  etatRequest = false;
  code:string;

  constructor(private fb: FormBuilder,private transS: TransService, private alertController: AlertController) { }

  ngOnInit() {
    this.bloquerTransaction = this.fb.group({
      code: ['', Validators.required]
    })
  }

  getCode(code:string){
    if(code === ""){
      this.etatRequest = false;
      return ;
    }
    this.transS.getTransactionByCode({code: code})
      .subscribe(
        (data) => {
          // @ts-ignore
          this.transaction = data;
          this.etatRequest = true;
          this.code = code;
        },
        async () => {
          this.etatRequest = false;
          // @ts-ignore
          this.transaction = "";
          const erreurCode = await this.alertController.create({
            header: 'Erreur Code',
            subHeader: 'INFOS',
            cssClass: 'basic-alert',
            mode:'ios',
            message: 'Ce code n\'existe pas .! ><ion-icon name="alert-circle-outline" [color]="#e04055"></ion-icon>'
          });
          await erreurCode.present();
        }
      )
  }
  bloquerTrans() {
    return this.transS.bloquerTransaction({code:this.code})
      .subscribe(
        async () => {
          const tranReussi = await this.alertController.create({
            header: 'Bloquer transaction',
            subHeader: 'INFOS',
            cssClass: 'basic-alert',
            mode:'ios',
            message: 'Votre transaction a ete bloquée avec succes'
          });
          await tranReussi.present();
          this.etatRequest = false;
        },
        async () => {
          const errBloque = await this.alertController.create({
            header: 'Erreur Bloquage transaction',
            subHeader: 'INFOS',
            cssClass: 'basic-alert',
            mode:'ios',
            message: 'Cette transaction est deja retirée! <ion-icon name="alert-circle-outline" [color]="#e04055"></ion-icon> '
          });
          await errBloque.present();
        }
      );
  }
}
