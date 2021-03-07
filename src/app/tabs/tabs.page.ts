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
  routeActive = 'mes-transactions';
  constructor(private router: Router, private authS: AuthService) {
    if (this.authS.decodeToken() === 'ROLE_AdminAgence')
    {
      this.permission = true;
      this.routeActive = 'transaction';
    }
  }

  ngOnInit() {
  }

}
