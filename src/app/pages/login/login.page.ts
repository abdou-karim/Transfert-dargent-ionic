import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {AuthService} from '../../_services/auth.service';



@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {
  loginForm: FormGroup;
  submitted = false;
  constructor(private router: Router, private fb: FormBuilder, private authS: AuthService) { }

  ngOnInit() {
    this.loginForm = this.fb.group({
      username: ['', Validators.required],
      password: ['', [Validators.required, Validators.pattern('(?=[^A-Z]*[A-Z])(?=[^a-z]*[a-z])(?=[^0-9]*[0-9]).{8,}')]]
    });
  }
  get f()
  {
    return this.loginForm.controls;
  }
  authUser()
  {
    this.submitted = true;
    if (this.loginForm.invalid)
    {
     return;
    }
    this.authS.login(this.f.username.value, this.f.password.value)
      .subscribe((data) => {
        });
  }

}
