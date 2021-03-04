import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { DepotPageRoutingModule } from './depot-routing.module';

import { DepotPage } from './depot.page';
import {EmetteurComponent} from './emetteur/emetteur.component';
import {BeneficiaireComponent} from './beneficiaire/beneficiaire.component';
import {SuperTabsModule} from '@ionic-super-tabs/angular';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    DepotPageRoutingModule,
    SuperTabsModule,
    ReactiveFormsModule
  ],
  exports: [
    BeneficiaireComponent
  ],
  declarations: [DepotPage, EmetteurComponent, BeneficiaireComponent]
})
export class DepotPageModule {}
