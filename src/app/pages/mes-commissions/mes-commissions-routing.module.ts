import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { MesCommissionsPage } from './mes-commissions.page';

const routes: Routes = [
  {
    path: '',
    component: MesCommissionsPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class MesCommissionsPageRoutingModule {}
