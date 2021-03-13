import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { AdminSystemePageRoutingModule } from './admin-systeme-routing.module';

import { AdminSystemePage } from './admin-systeme.page';
import {MenuComponent} from './menu/menu.component';
import {TousLesComptesComponent} from './tous-les-comptes/tous-les-comptes.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    AdminSystemePageRoutingModule
  ],
  declarations: [AdminSystemePage, MenuComponent, TousLesComptesComponent]
})
export class AdminSystemePageModule {}
