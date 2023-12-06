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
    return this.http.post("http://localhost:63342/PLWA/hw8/evil/backend.php", JSON.stringify(data));
  }
}
