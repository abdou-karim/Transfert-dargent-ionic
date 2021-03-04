import {Component, Input, OnInit} from '@angular/core';
import {Transaction} from '../../../_modeles/transaction';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {TransService} from '../../../_services/transactions/trans.service';

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
  constructor(private fb: FormBuilder, private transS: TransService) { }

  ngOnInit() {
    this.cniForm = this.fb.group({
      cni: ['',Validators.required]
    })
  }
  retrait(value: string){
    if(value !=="")
    {
      let retrait = {
        type: 'retrait',
        code: this.code,
        client:{
          cniBeneficiaire: value

        }
      }
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
}
