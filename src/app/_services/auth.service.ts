import { Injectable } from '@angular/core';
import {environment} from '../../environments/environment';
import {BehaviorSubject, Observable} from 'rxjs';
import {HttpClient} from '@angular/common/http';
import {ActivatedRoute, Router} from '@angular/router';
import {map} from 'rxjs/operators';
import {JwtHelperService} from '@auth0/angular-jwt';
import {Utilisateur} from '../_modeles/utilisateur';
import {Storage} from '@ionic/storage';
import {HTTP} from '@ionic-native/http/ngx';


@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private API_URL = environment.apiUrl;
  private currentUserSubject: BehaviorSubject<Utilisateur>;
  public currentUser: Observable<Utilisateur>;
  returnUrl: string;
  constructor(private http: HttpClient, private router: Router,
              private route: ActivatedRoute, private storage: Storage, private httpp: HTTP) {
    this.currentUserSubject = new BehaviorSubject<any>(this.storage.get('currentUser'));
    this.currentUser = this.currentUserSubject.asObservable();
    this.returnUrl = this.route.snapshot.queryParams.returnUrl || '/';
  }
  public get currentUserValue(): Utilisateur {
    return this.currentUserSubject.value;
  }
  // *
  logins(username: string, password: string, role?: {}) {
    return this.http.post<any>(`${this.API_URL}/login`, { username, password, roles: role })
      .pipe(
        // tslint:disable-next-line:no-shadowed-variable
        map(Users => {
          // store user details and jwt token in local storage to keep user logged in between page refreshes
         // localStorage.setItem('currentUser', JSON.stringify(Users));
          this.storage.set('currentUser', JSON.stringify(Users));
          this.currentUserSubject.next(Users);
          this.decodeToken();
          return Users;
        }));
  } // */
  login(username: string, password: string, role?: {}) {
    return this.httpp.post(`${this.API_URL}/login`, { username, password, roles: role }, {})
      .then(
        Users => {
          // store user details and jwt token in local storage to keep user logged in between page refreshes
          // localStorage.setItem('currentUser', JSON.stringify(Users));
          this.storage.set('currentUser', JSON.stringify(Users));
          // @ts-ignore
          this.currentUserSubject.next(Users);
          this.decodeToken();
          return Users;
        }
      );
  }
  logOut(){
    if (this.currentUserValue !== null){
      // localStorage.removeItem('currentUser');
      this.storage.remove('currentUser');
     // localStorage.removeItem(this.currentUserValue.token);
      this.storage.remove(this.currentUserValue.token);
    }
     // localStorage.removeItem('currentUser');
    this.storage.remove('currentUser');
   // localStorage.removeItem(this.currentUserValue.token);
    this.storage.remove(this.currentUserValue.token);
    // @ts-ignore
    this.currentUserSubject.next(null);
    this.router.navigate(['/login']);

  }
  decodeToken(){
    const token = this.currentUserValue.token;
    const helper = new JwtHelperService();
    const decodeToken = helper.decodeToken(token);
    if (decodeToken.roles[0] === 'ROLE_AdminAgence' || decodeToken.roles[0] === 'ROLE_UtilisateurAgence')
    {
      this.router.navigateByUrl('tabs/admin-agence');
    }
    if(decodeToken.roles[0] === 'ROLE_AdminSysteme' || decodeToken.roles[0] === 'ROLE_Caissier')
    {
      this.router.navigateByUrl('tabs/admin-systeme');
    }
    return decodeToken.roles[0];
  }
  getAllProfileByUsername(username: {}): Observable<Utilisateur>
  {
    return this.http.put<Utilisateur>(`${this.API_URL}/log/username`, username)
      .pipe(
        map( data => {
          return data;
        })
      );
  }
}
