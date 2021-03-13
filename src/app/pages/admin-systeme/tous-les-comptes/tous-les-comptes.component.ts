import { Component, OnInit } from '@angular/core';
import {CompteService} from '../../../_services/compte/compte.service';
import {Compte} from '../../../_modeles/compte';

@Component({
  selector: 'app-tous-les-comptes',
  templateUrl: './tous-les-comptes.component.html',
  styleUrls: ['./tous-les-comptes.component.scss'],
})
export class TousLesComptesComponent implements OnInit {
  compte : Compte[] = [];
  constructor(private compteS: CompteService) {
    this.getTousLesComptes();
  }

  ngOnInit() {}
  getTousLesComptes(){
    return this.compteS.getTousLesComptes()
      .subscribe(
        data => {
          this.compte = data['hydra:member'];
        }
      );
  }
}
