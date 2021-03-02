import { Injectable } from '@angular/core';
import {environment} from '../../../environments/environment';
import {HttpClient} from '@angular/common/http';
import {retry} from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class CompteService {
  private API_URL = environment.apiUrl;
  constructor(private http: HttpClient) { }
  getCompteAdminAgence(){
    return  this.http.get<any>(`${this.API_URL}/adminSysteme/adminAgence/compte`)
      .pipe(
        retry(1),
      );
  }
}
