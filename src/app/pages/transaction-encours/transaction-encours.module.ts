import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { TransactionEncoursPageRoutingModule } from './transaction-encours-routing.module';

import { TransactionEncoursPage } from './transaction-encours.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    TransactionEncoursPageRoutingModule
  ],
  declarations: [TransactionEncoursPage]
})
export class TransactionEncoursPageModule {}
