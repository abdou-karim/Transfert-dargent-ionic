import { Injectable } from '@angular/core';
import {environment} from '../../../environments/environment';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {map} from 'rxjs/operators';
import { HTTP } from '@ionic-native/http/ngx';
@Injectable({
  providedIn: 'root'
})
export class TransService {
  private API_URL = environment.apiUrl;
  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json'
    })
  };
  constructor(private http: HttpClient , private httpp: HTTP) { }

  depot(client: object){
    return this.http.post(`${this.API_URL}/transaction/client`, client, this.httpOptions)
      .pipe(
        map(
          data => {
            return data;
          }
        )
      );
  }
  getTransactionByCode(code:object){
    return this.http.put(`${this.API_URL}/transaction/code`,code, this.httpOptions)
      .pipe(
        map(
          data => {
            return data;
          }
        )
      );
  }
  retrait(cni:object){
    return this.http.post(`${this.API_URL}/transaction/client`, cni, this.httpOptions)
      .pipe(
        map( data => {
          return data;
        })
      );
  }
  getToutMesCommissions(){
    return this.http.get(`${this.API_URL}/transaction/mes_commision`)
      .pipe(
        map( data => {
          return data;
        })
      );
  }
 // *
  getMesTranscations(){
    return this.http.get(`${this.API_URL}/transaction/commisons_user`)
      .pipe(
        map( data => {
          return data;
        })
      );
  }
  // */
  getMesTranscation(){
    return this.httpp.get(`${this.API_URL}/transaction/commisons_user`, {}, {})
      .then(
        data => {
          return data.data;
        }
      );
  }
  bloquerTransaction(code: object){
    return this.http.put(`${this.API_URL}/transaction/bloquer`, code, this.httpOptions)
      .pipe(
        map(
          data => {
            return data;
          }
        )
      );
  }
  getTransactionEnCours()
  {
    return this.http.get(`${this.API_URL}/transaction/encours`).pipe(
      map(data => {
        return data;
      })
    );
  }
}
