import { Component } from '@angular/core';
import { Guess }  from "../guess";
import { GetWordService}  from "../get-word.service";

@Component({
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrl: './form.component.css'
})
export class FormComponent {
  guess:Guess;

  response:any;

  public history:Array<Guess> = [];
  constructor(
    private getWordService: GetWordService
  ) {
    this.guess = new Guess('',0,0);
  }

  guessWord(){
    let word = this.guess.g;
    let rightLetter = 0;
    let rightPosition = 0;
    let answer = 'test';
    for(let i = 0; i < word.length; i++){
      if(word.charAt(i) == answer.charAt(i)){
        rightPosition++;
      }
      if(answer.indexOf(word.charAt(i)) != -1){
        rightLetter++;
      }
    }
    this.guess.rightLetter = rightLetter;
    this.guess.rightPosition = rightPosition;
    this.history.push(this.guess);
    this.guess = new Guess('',0,0);
  }

  requireWord(){
    this.getWordService.sendRequest({}).subscribe(
      (respData) => {
        this.response = respData;
      }
    );
  }

  clearHistory(){
    this.history = [];
  }
}
