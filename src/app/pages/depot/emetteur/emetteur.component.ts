import {Component, Input, OnInit} from '@angular/core';
import {FraisService} from '../../../_services/calculFaris/frais.service';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {Router} from '@angular/router';

@Component({
  selector: 'app-emetteur',
  templateUrl: './emetteur.component.html',
  styleUrls: ['./emetteur.component.scss'],
})
export class EmetteurComponent implements OnInit {
  frais: number;
  Total: number;
  submited = false;
  @Input()BenClick: any;
  constructor(private fraisS: FraisService, private  fb: FormBuilder,
              private beneS: FraisService, private router: Router) { }
  emetteurForm: FormGroup;
  ngOnInit() {
    this.emetteurForm = this.fb.group({
      nomClient: ['', [Validators.required,Validators.pattern('^[A-Z][a-zA-Z? ]{5,20}$')]],
      numeroClient: ['', [Validators.required, Validators.pattern('^7[78065]([0-9]{3})([0-9]{2}){2}$')]],
      montant: ['', Validators.required]
    });
  }
  get e (){
    return this.emetteurForm.controls;
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
