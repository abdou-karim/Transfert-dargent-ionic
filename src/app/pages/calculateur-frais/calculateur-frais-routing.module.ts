import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { CalculateurFraisPage } from './calculateur-frais.page';

const routes: Routes = [
  {
    path: '',
    component: CalculateurFraisPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class CalculateurFraisPageRoutingModule {}
