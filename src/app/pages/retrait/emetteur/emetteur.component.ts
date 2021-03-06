import {Component, Input, OnInit} from '@angular/core';
import {Transaction} from '../../../_modeles/transaction';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {TransService} from '../../../_services/transactions/trans.service';
import {AlertController} from '@ionic/angular';

@Component({
  selector: 'app-emetteur',
  templateUrl: './emetteur.component.html',
  styleUrls: ['./emetteur.component.scss'],
})
export class EmetteurComponent implements OnInit {
@Input()Mtransction: Transaction;
@Input()code: string;
@Input()dateT: Date;
  cniForm: FormGroup;
  trans: Transaction;
  boo = false;
  mcni: string;
  constructor(private fb: FormBuilder, private transS: TransService, private alertController: AlertController) { }

  ngOnInit() {
    this.cniForm = this.fb.group({
      cni: ['',[Validators.required, Validators.pattern('^[0-9]{13}$')]]
    })
  }
  get c (){
    return this.cniForm.controls;
  }
  async retrait(){
    this.boo = true;
    if(this.cniForm.invalid || this.Mtransction.code === undefined){
      return;
    }
    this.mcni = this.c.cni.value;
    console.log( this.mcni);
      let retrait = {
        type: 'retrait',
        code: this.Mtransction.code,
        client:{
          cniBeneficiaire: this.mcni

        }
      }
      const confirRetrait = await this.alertController.create({
        header: 'Confirmation de Retrait',
        subHeader: 'INFOS',
        cssClass: 'basic-alert',
        mode:'ios',
        message: `<ion-list>
                        <ion-item>
                              <ion-label>BENEFICIAIRE <p>${this.Mtransction.client.nomBeneficiaire}</p></ion-label>
                        </ion-item>

                         <ion-item>
                              <ion-label>TELEPHONE <p>${this.Mtransction.client.numeroBeneficiaire}</p></ion-label>
                        </ion-item>

                        <ion-item>
                              <ion-label>N°CNI <p>${this.mcni}</p></ion-label>
                        </ion-item>

                        <ion-item>
                              <ion-label>MONTANT REÇU <p>${this.Mtransction.montant}</p></ion-label>
                        </ion-item>

                        <ion-item>
                              <ion-label>EMETTEUR <p>${this.Mtransction.client.nomClient}</p></ion-label>
                        </ion-item>

                         <ion-item>
                              <ion-label>TELEPHONE <p>${this.Mtransction.client.numeroClient}</p></ion-label>
                        </ion-item>
                   </ion-list>`,
        buttons:
          [
            {
              text:'Annuler',
            },
            {
              text:'Confirmer',
              cssClass:'confirm',
              handler: () => {
                this.transS.retrait(retrait).subscribe(
                  data => {
                    console.log(data);
                  },
                  () => {
                    alert('error')
                  }
                )
              }
            }
          ]
      });
    await confirRetrait.present();


    }
}
