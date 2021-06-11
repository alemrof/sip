@extends('layouts.master')

@section('custom-styles')
      
@endsection

@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Edytowanie sieci sklepów</h1>
  <p class="mb-4">Wypełnij wszystkie pola formularza</p>
  <div class="row">
      <div class="col-md-10 col-lg-8 col-xl-6">
          <div class="card">
              <div class="card-header bg-dark text-white">Sieć sklepów</div>
              <div class="card-body">
                  <form action="{{route('companies.update', $company->id)}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text form-control" id="name">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Nazwa" autofocus name="name" value="{{$company->name}}">
                    </div>
                    <input type="submit" class="btn btn-primary" value="Dodaj">
                  </form>
              </div>
            </div>  
      </div>
  </div>

@endsection

@section('custom-scripts')
      
@endsection