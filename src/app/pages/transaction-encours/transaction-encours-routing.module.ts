import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TransactionEncoursPage } from './transaction-encours.page';

const routes: Routes = [
  {
    path: '',
    component: TransactionEncoursPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TransactionEncoursPageRoutingModule {}
