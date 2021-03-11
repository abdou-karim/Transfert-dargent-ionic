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
  montant:number;
  routeActive = '/tabs/mes-transactions';
  maDate: string = new Date().toISOString();
  hideShowSomme =true;
  nameIcone = 'eye-outline';
  myDate = new Date();
  today: number = Date.now();

  constructor(private router: Router, private authS: AuthService, private compteS: CompteService) {
    if (this.authS.decodeToken() === 'ROLE_AdminAgence')
    {
        this.permission = true;
      this.routeActive = '/tabs/transaction';
    }
    this.getCompteAdminAgence();
  }

  ngOnInit() {
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
         this.montant = Number(this.compte.solde);

        }
      );
  }
  getClick() {
    this.getCompteAdminAgence();
    if(this.hideShowSomme === false){
      this.nameIcone ='eye-off-outline';
    }
    else
    {
      this.nameIcone = 'eye-outline';
    }
  }
}
