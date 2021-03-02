import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../../_services/auth.service';

@Component({
  selector: 'app-admin-agence',
  templateUrl: './admin-agence.page.html',
  styleUrls: ['./admin-agence.page.scss'],
})
export class AdminAgencePage implements OnInit {


  permission: boolean;
  constructor(private router: Router, private authS: AuthService) {
    if (this.authS.decodeToken() === 'ROLE_AdminAgence')
    {
      this.permission = true;
    }
  }


  ngOnInit() {
  }
}
