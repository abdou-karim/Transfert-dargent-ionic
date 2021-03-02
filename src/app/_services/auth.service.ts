import { Injectable } from '@angular/core';
import {environment} from '../../environments/environment';
import {BehaviorSubject, Observable} from 'rxjs';
import {HttpClient} from '@angular/common/http';
import {ActivatedRoute, Router} from '@angular/router';
import {map} from 'rxjs/operators';
import {JwtHelperService} from '@auth0/angular-jwt';
import {Utilisateur} from '../_modeles/utilisateur';


@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private API_URL = environment.apiUrl;
  private currentUserSubject: BehaviorSubject<Utilisateur>;
  public currentUser: Observable<Utilisateur>;
  returnUrl: string;
  constructor(private http: HttpClient, private router: Router, private route: ActivatedRoute) {
    this.currentUserSubject = new BehaviorSubject<Utilisateur>(JSON.parse(localStorage.getItem('currentUser')));
    this.currentUser = this.currentUserSubject.asObservable();
    this.returnUrl = this.route.snapshot.queryParams.returnUrl || '/';
  }
  public get currentUserValue(): Utilisateur {
    return this.currentUserSubject.value;
  }
  login(username: string, password: string) {
    return this.http.post<any>(`${this.API_URL}/login`, { username, password })
      .pipe(
        // tslint:disable-next-line:no-shadowed-variable
        map(Users => {
          // store user details and jwt token in local storage to keep user logged in between page refreshes
          localStorage.setItem('currentUser', JSON.stringify(Users));
          this.currentUserSubject.next(Users);
          this.decodeToken();
          return Users;
        }));
  }
  logOut(){
    if (this.currentUserValue !== null){
      localStorage.removeItem('currentUser');
      localStorage.removeItem(this.currentUserValue.token);
    }
    localStorage.removeItem('currentUser');
    localStorage.removeItem(this.currentUserValue.token);
    // @ts-ignore
    this.currentUserSubject.next(null);
    this.router.navigate(['/login']);

  }
  decodeToken(){
    const token = this.currentUserValue.token;
    const helper = new JwtHelperService();
    const decodeToken = helper.decodeToken(token);
    if (decodeToken.roles[0] === 'ROLE_AdminAgence' || decodeToken.roles[0] === 'ROLE_UtilisateurAgence') {
      this.router.navigateByUrl('tabs/admin-agence');
      return decodeToken.roles[0];
    }
  }
}
