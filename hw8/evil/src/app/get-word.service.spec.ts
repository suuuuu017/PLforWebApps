import { TestBed } from '@angular/core/testing';

import { GetWordService } from './get-word.service';

describe('GetWordService', () => {
  let service: GetWordService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(GetWordService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
