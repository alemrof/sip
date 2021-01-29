@extends('layouts.master')

@section('custom-styles')
      
@endsection

@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Edytowanie produktów</h1>
  <p class="mb-4">Wypełnij wszystkie pola formularza</p>
  <div class="row">
      <div class="col-md-10 col-lg-8 col-xl-6">
          <div class="card">
              <div class="card-header bg-dark text-white">Produkt</div>
              <div class="card-body">
                  <form action="{{route('products.update', $product->id)}}" method="POST">
                    {{csrf_field()}}
                    {{-- Nazwa produktu --}}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text form-control" id="name">Nazwa</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Nazwa" autofocus name="name" value="{{$product->name}}">
                    </div>
                    {{-- Kategorie produktów --}}
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="category">Kategoria</label>
                      </div>
                      <select class="custom-select" id="category" name="company_id">
                        @foreach ($categories as $category)
                          @if ($category->id === $product->company_id)
                            <option selected value="{{$category->id}}">{{$category->name}}</option>
                          @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                          @endif
                        @endforeach
                      </select>
                    </div>
                    {{-- Producent --}}
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text form-control" id="manufacturer">Producent</span>
                      </div>
                      <input type="text" class="form-control" aria-label="Producent" autofocus name="manufacturer" value="{{$product->manufacturer}}">
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