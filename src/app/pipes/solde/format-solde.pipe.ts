import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'formatSolde'
})
export class FormatSoldePipe implements PipeTransform {

  transform(value: unknown, ...args: unknown[]): unknown {
    return null;
  }

}
