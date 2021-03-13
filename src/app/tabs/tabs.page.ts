import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../_services/auth.service';

@Component({
  selector: 'app-tabs',
  templateUrl: './tabs.page.html',
  styleUrls: ['./tabs.page.scss'],
})
export class TabsPage implements OnInit {


  permission: boolean;
  permissionAdAndUserAg: boolean;
  routeActive = 'mes-transactions';
  routeAdmin = 'admin-agence';
  constructor(private router: Router, private authS: AuthService) {
    if (this.authS.decodeToken() === 'ROLE_AdminAgence')
    {
      this.permission = true;
      this.routeActive = 'transaction';
    }
    if (this.authS.decodeToken() === 'ROLE_AdminAgence' || this.authS.decodeToken() === 'ROLE_UtilisateurAgence'){
      this.permissionAdAndUserAg = true;
    }
    if(this.authS.decodeToken() === 'ROLE_AdminSysteme' || this.authS.decodeToken() === 'ROLE_Caissier'){
      this.routeAdmin = 'admin-systeme';
    }
  }

  ngOnInit() {
  }

}
