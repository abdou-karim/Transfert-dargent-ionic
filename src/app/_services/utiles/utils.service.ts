import { Injectable } from '@angular/core';
import {BehaviorSubject} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UtilsService {
  private etatTransaction = new BehaviorSubject(false);
  constructor() { }

  // tslint:disable-next-line:typedef
   formatPrice( nbr: number, seo: string){
    let nombre: string = nbr.toString();
     let reg = /(\d+)(\d{3})/;
    if(nombre.length === 7){
      reg = /(\d+)(\d{6})/;
    }
    if(nombre.length === 10){
      reg = /(\d+)(\d{9})/;
    }
    while ( reg.test( nombre)) {
      nombre = nombre.replace( reg, '$1' + seo + '$2');
    }
    return nombre;
  }
  get valueEtatTranaction(){
    return  this.etatTransaction.value;
  }
  setEtatTransaction(boole: boolean){
    this.etatTransaction.next(boole);
  }
}
