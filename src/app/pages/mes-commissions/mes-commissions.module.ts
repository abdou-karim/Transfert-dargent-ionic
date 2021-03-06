import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { MesCommissionsPageRoutingModule } from './mes-commissions-routing.module';

import { MesCommissionsPage } from './mes-commissions.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    MesCommissionsPageRoutingModule
  ],
  declarations: [MesCommissionsPage]
})
export class MesCommissionsPageModule {}
