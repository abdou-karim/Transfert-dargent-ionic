import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {AuthService} from '../../_services/auth.service';
import {AlertController, Platform} from '@ionic/angular';
import {Profile} from '../../_modeles/Profile';
import {Utilisateur} from '../../_modeles/utilisateur';



@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  loginForm: FormGroup;
  submitted = false;
  newBoo = false;
  profile: Utilisateur;
  role = [];

  constructor(private router: Router, private fb: FormBuilder, private authS: AuthService,
              private alertControll: AlertController, private platform: Platform) {
  }

  ngOnInit() {
    this.loginForm = this.fb.group({
      username: ['', [Validators.required, Validators.pattern('^7[78065]([0-9]{3})([0-9]{2}){2}$')]],
      password: ['', [Validators.required, Validators.pattern('(?=[^A-Z]*[A-Z])(?=[^a-z]*[a-z])(?=[^0-9]*[0-9]).{8,}')]]
    });
  }

  get f() {
    return this.loginForm.controls;
  }

  getAllProfiles(value: string | number) {
    const username = {username: value};
    this.authS.getAllProfileByUsername(username).subscribe(
      data => {
        this.profile = data;
        this.newBoo = true;
      },
      () => {
        this.newBoo = false;
      }
    );
  }

  checkProfile(optionValue: string) {
    const role = ['ROLE_' + optionValue];
    this.role = role;
    console.log(this.role);
  }
  authUser() {
    this.submitted = true;
    if (this.loginForm.invalid) {
      return;
    }
    if (this.platform.is('cordova')) {
      this.authS.login(this.f.username.value, this.f.password.value,  this.role)
        .then(() => {
          },
          async () => {
            const alert = await this.alertControll.create({
              cssClass: 'basic-alert',
              header: 'Login ou Password *',
              message: '' +
                '<p>Vous n\'etes pas autorisé a vous connecter !</p><ion-spinner name="lines"></ion-spinner>',
            });

            await alert.present();
          }
        );
    }
    else
    {
      this.authS.logins(this.f.username.value, this.f.password.value,  this.role)
        .subscribe(() => {
          },
          async () => {
            const alert = await this.alertControll.create({
              cssClass: 'basic-alert',
              header: 'Login ou Password *',
              message: '' +
                '<p>Vous n\'etes pas autorisé a vous connecter !</p><ion-spinner name="lines"></ion-spinner>',
            });

            await alert.present();
          }
        );
    }
  }
}
