import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { TabsPage } from './tabs.page';
import {AuthGuard} from '../_guards/auth.guard';

const routes: Routes = [
  {
    path: '',
    component: TabsPage,
    children:
      [
        {
          path: 'admin-agence',
          children:
            [
              {
                path: '',
                loadChildren: () => import('../pages/admin-agence/admin-agence.module').then(m => m.AdminAgencePageModule), canActivate: [AuthGuard]

              }
            ]
        },
        {
          path: 'calcule-frais',
          children:
            [
              {
                path: '',
                loadChildren: () => import('../pages/calculateur-frais/calculateur-frais.module').then( m => m.CalculateurFraisPageModule)

              }
            ]
        }
        ,
        {
          path: 'transaction',
          children:
            [
              {
                path: '',
                loadChildren: () => import('../pages/transaction/transaction.module').then( m => m.TransactionPageModule)
              }
            ]
        }
      ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class TabsPageRoutingModule {}
