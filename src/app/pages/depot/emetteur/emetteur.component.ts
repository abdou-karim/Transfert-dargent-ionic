import {Component, Input, OnInit} from '@angular/core';
import {FraisService} from '../../../_services/calculFaris/frais.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-emetteur',
  templateUrl: './emetteur.component.html',
  styleUrls: ['./emetteur.component.scss'],
})
export class EmetteurComponent implements OnInit {
  frais: number;
  Total: number;
  submited = false;
  constructor(private fraisS: FraisService, private  fb: FormBuilder, private beneS: FraisService) { }
  emetteurForm: FormGroup;
  ngOnInit() {
    this.emetteurForm = this.fb.group({
      nomClient: ['', Validators.required],
      numeroClient: ['', Validators.required],
      montant: ['', Validators.required]
    });
  }

  getFrais( montant: number){
    montant = Number(montant)
    if(montant <500){
      this.frais = 0;
      this.Total = 0;
    }else {
      this.frais = this.fraisS.calcalueFraisTransfert(montant);
      this.Total = montant + this.frais;
    }
  }
  emetteurSubmit(){
    this.submited = true;
    if(this.emetteurForm.invalid)
    {
      return;
    }
    this.beneS.beneFVlaue(this.emetteurForm.value);
  }

}
