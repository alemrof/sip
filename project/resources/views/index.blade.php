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
    </script>

    <div id="map" class="map mt-3 border border-dark"></div>

    <!-- Okienko z atrybutami składu budowlanego -->
    <div class="card border-dark" id="popup" style="width: 15rem;">
        <div class="card-header bg-dark text-white">
            <span class="align-middle" id="warehouse-name">Nazwa składu</span>
            <button type="button" class="close" id="closer">
                <span aria-hidden="true" class="text-white">&times;</span>
            </button>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item" id="warehouse-company">Sieć sklepów</li>
            <li class="list-group-item" id="warehouse-address">Adres XXX, 00-000 Miejscowość</li>
            <li class="list-group-item" id="warehouse-location">Położenie</li>
        </ul>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="" class="btn btn-light btn-sm border-dark" id="route-link"><i class="fas fa-route"></i></a>
                <a href="" class="btn btn-light btn-sm border-dark" id="offer-link">Oferta</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="" class="btn btn-light btn-sm border-dark" id="edit-link"><i class="fas fa-edit"></i></a>
                        <a href="" class="btn btn-light btn-sm border-dark" id="editMap-link"><i class="fas fa-map-marked"></i></a>
                    @endif
                @endauth
            </div>
            <div class="d-flex justify-content-between pb-0" id="popupArrows">
                <a href=""><i class="fas fa-long-arrow-alt-left fa-3x" id="popupPreviousWarehouse"></i></a>
                <a href=""><i class="fas fa-long-arrow-alt-right fa-3x" id="popupNextWarehouse"></i></a>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script src="{{asset('js/map.js')}}"></script>
@endsection