import { Injectable } from '@angular/core';
import {environment} from '../../../environments/environment';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {map} from 'rxjs/operators';

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
  constructor(private http: HttpClient) { }

  depot(client:object){
    return this.http.post(`${this.API_URL}/transaction/client`, client, this.httpOptions)
      .pipe(
        map(
          data => {
            console.log(data);
            return data;
          }
        )
      );
  }
}
