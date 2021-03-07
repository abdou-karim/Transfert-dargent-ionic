import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { BloquerTransactionPage } from './bloquer-transaction.page';

const routes: Routes = [
  {
    path: '',
    component: BloquerTransactionPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class BloquerTransactionPageRoutingModule {}
