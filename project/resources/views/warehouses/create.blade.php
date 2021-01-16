@extends('layouts.master')

@section('custom-styles')
      
@endsection

@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Tworzenie składu budowlanego</h1>
  <p class="mb-4">Wypełnij wszystkie pola formularza</p>
  <div class="row">
      <div class="col-md-10 col-lg-8 col-xl-6">
          <div class="card">
              <div class="card-header bg-dark text-white">Skład budowlany</div>
              <div class="card-body">
                  <form action="{{route('warehouses.store')}}" method="POST">
                    {{csrf_field()}}
                    {{-- Nazwa składu --}}
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text form-control" id="name">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Nazwa" autofocus name="name">
                    </div>
                    {{-- Sieć sklepów --}}
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="company">Sieć sklepów</label>
                      </div>
                      <select class="custom-select" id="company" name="company_id">
                        <option selected></option>
                        @foreach ($companies as $company)
                          <option value="{{$company->id}}">{{$company->name}}</option>
                        @endforeach
                      </select>
                    </div>
                    {{-- Adres --}}
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text form-control" id="address">Adres</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Adres" name="address">
                    </div>
                    {{-- Submit --}}
                    <input type="submit" class="btn btn-primary" value="Dodaj">
                  </form>
              </div>
            </div>  
      </div>
  </div>
@endsection

@section('custom-scripts')
      
@endsection