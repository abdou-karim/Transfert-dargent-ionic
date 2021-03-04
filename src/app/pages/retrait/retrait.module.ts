import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { RetraitPageRoutingModule } from './retrait-routing.module';

import { RetraitPage } from './retrait.page';
import {SuperTabsModule} from '@ionic-super-tabs/angular';
import {EmetteurComponent} from './emetteur/emetteur.component';
import {RecepteurComponent} from './recepteur/recepteur.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RetraitPageRoutingModule,
    SuperTabsModule,
    ReactiveFormsModule
  ],
  declarations: [RetraitPage, EmetteurComponent, RecepteurComponent]
})
export class RetraitPageModule {}
