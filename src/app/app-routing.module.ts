import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import {AuthGuard} from './_guards/auth.guard';

const routes: Routes = [
  {
    path: 'home',
    loadChildren: () => import('./home/home.module').then( m => m.HomePageModule)
  },
/*  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full'
  },*/
  {
    path: 'login',
    loadChildren: () => import('./pages/login/login.module').then( m => m.LoginPageModule)
  },
  {
    path: 'depot',
    loadChildren: () => import('./pages/depot/depot.module').then( m => m.DepotPageModule), canActivate: [AuthGuard]
  },
  {
    path: 'tabs',
    loadChildren: () => import('./tabs/tabs.module').then(m => m.TabsPageModule)
  },
  {
    path: 'retrait',
    loadChildren: () => import('./pages/retrait/retrait.module').then( m => m.RetraitPageModule)
  },
  {
    path: 'mes-transactions',
    loadChildren: () => import('./pages/mes-transactions/mes-transactions.module').then( m => m.MesTransactionsPageModule)
  },
  {
    path: 'bloquer-transaction',
    loadChildren: () => import('./pages/bloquer-transaction/bloquer-transaction.module').then( m => m.BloquerTransactionPageModule)
  }
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}

