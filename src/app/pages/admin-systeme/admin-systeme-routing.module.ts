import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { AdminSystemePage } from './admin-systeme.page';

const routes: Routes = [
  {
    path: '',
    component: AdminSystemePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class AdminSystemePageRoutingModule {}
