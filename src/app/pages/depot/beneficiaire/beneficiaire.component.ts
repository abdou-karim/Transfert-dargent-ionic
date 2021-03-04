import {Component, Input, OnInit, Output, EventEmitter} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {BehaviorSubject} from 'rxjs';
import {FraisService} from '../../../_services/calculFaris/frais.service';
import {TransService} from '../../../_services/transactions/trans.service';


@Component({
  selector: 'app-beneficiaire',
  templateUrl: './beneficiaire.component.html',
  styleUrls: ['./beneficiaire.component.scss'],
})
export class BeneficiaireComponent implements OnInit {
  beneficiaireForm: FormGroup
  is_submit = false;
  constructor(private fb: FormBuilder, private beneIn: FraisService, private transS: TransService) { }
  ngOnInit() {
    this.beneficiaireForm = this.fb.group({
      nomBeneficiaire : ['', Validators.required],
      numeroBeneficiaire: ['', Validators.required]
    });
  }
  // @ts-ignore

  beneSubmit(){
    this.is_submit = true;
    if(this.beneficiaireForm.invalid)
    {
      return;
    }
    alert('ok');
    // @ts-ignore
    let montant = this.beneIn.valueBen.montant
    // @ts-ignore
    let nomClient = this.beneIn.valueBen.nomClient
    // @ts-ignore
    let numeroClient = this.beneIn.valueBen.numeroClient
    // @ts-ignore
    let client =
      {
        montant: Number(montant),
        type: 'depot',
        client: {
          nomClient: nomClient,
          numeroClient: numeroClient,
          nomBeneficiaire: this.beneficiaireForm.controls.nomBeneficiaire.value,
          numeroBeneficiaire: this.beneficiaireForm.controls.numeroBeneficiaire.value
        }
      };
      this.transS.depot(client).subscribe(
        data => {
          console.log(data);
        }
      );
  }

}
