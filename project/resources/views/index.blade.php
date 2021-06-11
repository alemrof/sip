@extends('layouts.master')

@section('topbar-search')
<!-- Topbar Search -->
  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
        id="warehouse-search-form">
    <div class="input-group">
      <input type="text" id="warehouse-search-name" class="form-control bg-light border-0 small" placeholder="Wyszukaj skład..." aria-label="Search" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-dark" type="button" id="warehouse-search-button">
          <i class="fas fa-search fa-sm"></i>
        </button>
      </div>
    </div>
  </form>

    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" id="long">
        <div class="input-group">
            <input type="text"  disabled id="coordsText1" class="form-control bg-light border-0 small" placeholder="" aria-label="Search" aria-describedby="basic-addon2" >
        </div>
    </form>
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" id="lat" >
        <div class="input-group">
            <input type="text" disabled id="coordsText2" class="form-control bg-light border-0 small" placeholder="" aria-label="Search" aria-describedby="basic-addon2" >
        </div>
    </form>
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <button class="btn btn-primary" data-toggle="button" aria-pressed="false" autocomplete="off" type="button" id="change-button" onclick="return posButtonChange(this)">Ustaw nowa pozycje</button>
    </form>
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" > <div class="input-group">
            <a href="/search" type="button" class="btn btn-light border-dark ml-2">Szukaj Produktu</a> </div>
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
    @include('contextmenu')

@endsection

@section('custom-scripts')
    <script src="{{asset('js/map.js')}}"></script>
    <script src="{{asset('js/warehouse-card.js')}}"></script>
@endsection
