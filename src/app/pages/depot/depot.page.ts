import {ApplicationRef, Component, ComponentFactoryResolver, EmbeddedViewRef, Injector, OnInit} from '@angular/core';
import {EmetteurComponent} from './emetteur/emetteur.component';
import {BeneficiaireComponent} from './beneficiaire/beneficiaire.component';

@Component({
  selector: 'app-depot',
  templateUrl: './depot.page.html',
  styleUrls: ['./depot.page.scss'],
})
export class DepotPage implements OnInit {
  compo : any;
  Emmetteur = EmetteurComponent;
  Beneficiare = BeneficiaireComponent;
  constructor(private componentFactoryResolver: ComponentFactoryResolver,
              private appRef: ApplicationRef,
              private injector: Injector) { }

  ngOnInit() {
  }
  clear(v: string){
    if(v === 'a')
    {
      document.querySelector('.routerOutlet').innerHTML ='';
      this.compo = EmetteurComponent;
    }
    if (v === 'b')
    {
      document.querySelector('.routerOutlet').innerHTML ='';
      this.compo = BeneficiaireComponent
    }
    const componentRef = this.componentFactoryResolver
      .resolveComponentFactory(this.compo)
      .create(this.injector);
    this.appRef.attachView(componentRef.hostView);
    const domElem = (componentRef.hostView as EmbeddedViewRef<any>)
      .rootNodes[0] as HTMLElement;
    document.querySelector('.routerOutlet').appendChild(domElem);


  }
}
