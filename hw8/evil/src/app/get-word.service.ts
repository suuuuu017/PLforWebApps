import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class GetWordService {

  constructor(
    private http:HttpClient
  ) { }

  sendRequest(data:any):Observable<any>{
    return this.http.post("https://cs4640.cs.virginia.edu/qvw9pv/hw8/wordle_api.php", JSON.stringify(data));
  }
}
