import { Pipe, PipeTransform } from '@angular/core';
import {UtilsService} from '../../_services/utiles/utils.service';


@Pipe({
  name: 'separator'
})
export class SeparatorPipe implements PipeTransform {
  constructor(private  utilService: UtilsService) {
  }

  transform(value: number, seo: string): string {
    return this.utilService.formatPrice(value, seo);
  }

}
