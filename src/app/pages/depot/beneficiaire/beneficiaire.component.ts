import {Component, Input, OnInit, Output, EventEmitter} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {BehaviorSubject} from 'rxjs';
import {FraisService} from '../../../_services/calculFaris/frais.service';
import {TransService} from '../../../_services/transactions/trans.service';
import {AlertController} from '@ionic/angular';
import {Transaction} from '../../../_modeles/transaction';
import {Router} from '@angular/router';


@Component({
  selector: 'app-beneficiaire',
  templateUrl: './beneficiaire.component.html',
  styleUrls: ['./beneficiaire.component.scss'],
})
export class BeneficiaireComponent implements OnInit {
  beneficiaireForm: FormGroup
  is_submit = false;
  transaction: Transaction;
  constructor(private fb: FormBuilder, private beneIn: FraisService,
              private transS: TransService, private alerteCont: AlertController,
              private router: Router) { }
  ngOnInit() {
    this.beneficiaireForm = this.fb.group({
      nomBeneficiaire : ['', [Validators.required, Validators.pattern('^[A-Z][a-zA-Z? ]{5,20}$')]],
      numeroBeneficiaire: ['', [Validators.required, Validators.pattern('^7[78065]([0-9]{3})([0-9]{2}){2}$')]]
    });
  }
  get b (){
    return this.beneficiaireForm.controls
  }
  async beneSubmit() {
    this.is_submit = true;
    if (this.beneficiaireForm.invalid) {
      return;
    }
    // @ts-ignore
    let montant = Number(this.beneIn.valueBen.montant);
    // @ts-ignore
    let nomClient = this.beneIn.valueBen.nomClient;
    // @ts-ignore
    let numeroClient = this.beneIn.valueBen.numeroClient;
    let nomBene = this.beneficiaireForm.controls.nomBeneficiaire.value;
    let numBene = this.beneficiaireForm.controls.numeroBeneficiaire.value;
    // @ts-ignore
    let client =
      {
        montant: montant,
        type: 'depot',
        client: {
          nomClient: nomClient,
          numeroClient: numeroClient,
          nomBeneficiaire: nomBene,
          numeroBeneficiaire: numBene
        }
      };
    const alert = await this.alerteCont.create({
      header: 'Confirmation',
      cssClass: 'basic-alert',
      mode:'ios',
      message: `<ion-list>
                   <ion-item>
                    <ion-label>EMETTEUR <p>${nomClient}</p></ion-label>
                    </ion-item>

                    <ion-item>
                           <ion-label>TELEPHONE <p>${numeroClient}</p></ion-label>
                    </ion-item>

                     <ion-item>
                            <ion-label>MONTANT  <p>${montant}</p></ion-label>
                    </ion-item>

                    <ion-item>
                            <ion-label>RECEPTEUR <p>${nomBene}</p></ion-label>
                    </ion-item>

                    <ion-item>
                            <ion-label>TELEPHONE RECEPTEUR <p>${this.beneficiaireForm.controls.numeroBeneficiaire.value}</p></ion-label>
                    </ion-item>

                </ion-list>`,
      buttons: [
        {
          text: 'Annuler',
        },
        {
          text: 'Confirmer',
          cssClass: 'confirm',
          handler: () => {
            this.transS.depot(client).subscribe(
              async (data) => {
                // @ts-ignore
                this.transaction = data;
                const msg = await this.alerteCont.create({
                  header: 'Transfert reussi',
                  subHeader: 'INFOS',
                  cssClass: 'basic-alert',
                  mode:'ios',
                  message:`Vous avez envoyé ${this.transaction.montant} a ${this.transaction.client.nomBeneficiaire} le ${this.transaction.dateTransfert || data}`
                  + `<ion-item><ion-label>CODE TRANSACTION <p>${this.transaction.code}</p></ion-label></ion-item>`,
                  buttons: [
                    {
                      text:'',
                      cssClass:'shar',
                    },
                    {
                      text:'',
                      cssClass: 'sms'
                    }
                  ]
                });
                await msg.present();
                this.router.navigateByUrl('tabs/admin-agence')
              },
              async () => {
                  const errorMsg = await  this.alerteCont.create(({
                    header: 'Erreur Transfert',
                    subHeader: 'INFOS',
                    cssClass: 'basic-alert',
                    mode:'ios',
                    message: 'Votre solde est insuffisant ! </p><ion-icon name="alert-circle-outline" [color]="#e04055"></ion-icon>'

                  }));
                await errorMsg.present();
              }
            );
          }
        }
      ]
    });

    await alert.present();
  }

}
