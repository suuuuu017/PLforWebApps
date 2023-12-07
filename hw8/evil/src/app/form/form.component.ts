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

  answer:string;

  public history:Array<Guess> = [];
  constructor(
    private getWordService: GetWordService
  ) {
    this.guess = new Guess('',0,0, 'empty');
    this.answer = '';
  }

  guessWord(){
    let word = this.guess.g;
    word = word.toLowerCase();
    word = word.trim();
    let rightLetter = 0;
    let rightPosition = 0;
    // let answer =
    let answer = this.answer;
    answer = answer.toLowerCase();
    answer = answer.trim();
    let haveappeared = [];
    for(let i = 0; i < word.length; i++){
      if(word.charAt(i) == answer.charAt(i)){
        rightPosition++;
      }
      if(answer.indexOf(word.charAt(i)) != -1){
        if(haveappeared.indexOf(word.charAt(i)) == -1){
          rightLetter++;
          haveappeared.push(word.charAt(i));
        }
      }
    }
    this.guess.rightLetter = rightLetter;
    this.guess.rightPosition = rightPosition;
    if(this.answer.length == 0){
      this.guess.type = 'empty';
    }
    else if(this.guess.rightPosition === answer.length){
      this.guess.type = 'correct';
      this.history.push(this.guess);
      this.guess = new Guess('',0,0, 'correct');
      return;
    }
    else if(word.length < answer.length){
      this.guess.type = 'short';
    }
    else if(word.length > answer.length){
      this.guess.type = 'long';
    }
    else{
      this.guess.type = 'wrong but same length';
    }
    this.history.push(this.guess);
    this.guess = new Guess('',0,0, '');
  }

  requireWord(){
    this.guess = new Guess('',0,0, '');
    this.getWordService.sendRequest({}).subscribe(
      (respData) => {
        this.response = respData;
        this.answer = this.response;
      }
    );
  }

  clearHistory(){
    this.history = [];
  }

  protected readonly alert = alert;
}
