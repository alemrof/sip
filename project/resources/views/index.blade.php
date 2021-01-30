@extends('layouts.master')

@section('topbar-search')
<!-- Topbar Search -->
  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
      <input type="text" class="form-control bg-light border-0 small" placeholder="Wyszukaj skład..." aria-label="Search" aria-describedby="basic-addon2" id="warehouse-search-name">
      <div class="input-group-append">
        <button class="btn btn-dark" type="button" id="warehouse-search">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>
@endsection

@section('content')
    <script>
        var warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
        var openingHours = JSON.parse('{!! json_encode($openingHours) !!}');
    </script>

    <div id="map" class="map mt-3 border border-dark"></div>

    <!-- Okienko z atrybutami składu budowlanego -->
    @include('warehouse-card')

@endsection

@section('custom-scripts')
    <script src="{{asset('js/map.js')}}"></script>
    <script src="{{asset('js/warehouse-card.js')}}"></script>
@endsection