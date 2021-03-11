import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UtilsService {

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
}
