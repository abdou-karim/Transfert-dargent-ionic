import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../../../_services/auth.service';
import {CompteService} from '../../../_services/compte/compte.service';
import {Compte} from '../../../_modeles/compte';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.scss'],
})
export class MenuComponent implements OnInit {
  permission: boolean;
  compte: Compte;
  maDate: string = new Date().toISOString();
  constructor(private router: Router, private authS: AuthService, private compteS: CompteService) {
    if (this.authS.decodeToken() === 'ROLE_AdminAgence')
    {
        this.permission = true;
    }
  }

  ngOnInit() {
    this.getCompteAdminAgence();
  }
  deconnexion(){
   this.authS.logOut();
  }
  depot(){
    this.router.navigateByUrl('depot');
  }
  getCompteAdminAgence(){
    return this.compteS.getCompteAdminAgence()
      .subscribe(
        data => {
         this.compte = data;
         console.log(this.compte);
        }
      );
  }
}
