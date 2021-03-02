import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { DepotPage } from './depot.page';
import {EmetteurComponent} from './emetteur/emetteur.component';
import {BeneficiaireComponent} from './beneficiaire/beneficiaire.component';

const routes: Routes = [
  {
    path: '',
    component: DepotPage,
    children:
      [
        {
          path: 'emetteur', component: EmetteurComponent
        },
        {
          path: 'beneficiaire', component: BeneficiaireComponent
        }
      ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class DepotPageRoutingModule {}
