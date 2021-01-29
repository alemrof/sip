@extends('layouts.master')

@section('custom-styles')
      
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Dodawanie produktów do oferty składu: {{$warehouse->name}}</h1>
<p class="mb-4">Wypełnij wszystkie pola formularza</p>
<div class="row">
    <div class="col-md-10 col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header bg-dark text-white">Produkt</div>
            <div class="card-body">
                <form action="{{route('offers.store', $warehouse->id)}}" method="POST">
                  {{csrf_field()}}
                  {{-- Skład --}}
                  <input type="hidden" name="warehouse_id" value="{{$warehouse->id}}">
                  {{-- Produkt --}}
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="product_id">Produkt</label>
                    </div>
                    <select class="custom-select" id="product_id" name="product_id">
                      <option selected></option>
                      @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  {{-- Cena --}}
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text form-control" id="price">Cena</span>
                    </div>
                    <input type="number" min="0" max="999" step="0.01"  class="form-control" aria-label="Cena" name="price">
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