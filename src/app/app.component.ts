import { Component } from '@angular/core';
import {Platform} from '@ionic/angular';
import {StatusBar} from '@ionic-native/status-bar/ngx';
import {Router} from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss'],
})
export class AppComponent {
  constructor(private platform: Platform, private statutBar: StatusBar, private router: Router) {
    this.initializeApp();
  }
  initializeApp(){
    this.platform.ready().then(() => {
      this.statutBar.styleDefault();
      this.router.navigateByUrl('home');
    })
  }
}
