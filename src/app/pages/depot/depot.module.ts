import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { DepotPageRoutingModule } from './depot-routing.module';

import { DepotPage } from './depot.page';
import {EmetteurComponent} from './emetteur/emetteur.component';
import {BeneficiaireComponent} from './beneficiaire/beneficiaire.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    DepotPageRoutingModule,
  ],
  declarations: [DepotPage, EmetteurComponent, BeneficiaireComponent]
})
export class DepotPageModule {}