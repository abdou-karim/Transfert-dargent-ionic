import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { BloquerTransactionPageRoutingModule } from './bloquer-transaction-routing.module';

import { BloquerTransactionPage } from './bloquer-transaction.page';
import {HttpClientModule} from '@angular/common/http';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    BloquerTransactionPageRoutingModule,
    ReactiveFormsModule,
    HttpClientModule,
  ],
  declarations: [BloquerTransactionPage]
})
export class BloquerTransactionPageModule {}
