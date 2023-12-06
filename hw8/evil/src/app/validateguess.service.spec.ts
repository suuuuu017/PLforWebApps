import { TestBed } from '@angular/core/testing';

import { ValidateguessService } from './validateguess.service';

describe('ValidateguessService', () => {
  let service: ValidateguessService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ValidateguessService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
