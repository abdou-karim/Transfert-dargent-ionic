import {Component, Input, OnInit} from '@angular/core';
import {Transaction} from '../../../_modeles/transaction';

@Component({
  selector: 'app-recepteur',
  templateUrl: './recepteur.component.html',
  styleUrls: ['./recepteur.component.scss'],
})
export class RecepteurComponent implements OnInit {
  @Input()Mtran: Transaction;
  constructor() { }

  ngOnInit() {}

}
