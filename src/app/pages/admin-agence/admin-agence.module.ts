import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import {IonicModule} from '@ionic/angular';

import { AdminAgencePageRoutingModule } from './admin-agence-routing.module';

import { AdminAgencePage } from './admin-agence.page';
import {MenuComponent} from './menu/menu.component';
import {SeparatorPipe} from '../../pipes/separator/separator.pipe';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule.forRoot(),
    AdminAgencePageRoutingModule,
  ],
    declarations: [AdminAgencePage, MenuComponent, SeparatorPipe]
})
export class AdminAgencePageModule {}
