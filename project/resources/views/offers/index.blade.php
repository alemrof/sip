@extends('layouts.master')

@section('custom-styles')
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">    
@endsection

@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Oferta składu: <a href="{{route('warehouses.show', $warehouse->id)}}">{{$warehouse->name}}</a></h1>
  <p class="mb-4">Naciśnij wiersz aby wyświetlić wpis</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    @auth
      @if (auth()->user()->isAdmin())
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">
              <a href="{{route('offers.create', $warehouse->id)}}">
                  <span>Nowy</span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                      <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                  </svg>
              </a>
          </h6>
        </div>
      @endif
    @endauth
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nazwa</th>
              <th>Kategoria</th>
              <th>Producent</th>
              <th>Cena</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Nazwa</th>
              <th>Kategoria</th>
              <th>Producent</th>
              <th>Cena</th>
            </tr>
          </tfoot>
          <tbody>
          @foreach ($products as $product)
              <tr onclick="window.location='/warehouses/{{$warehouse->id}}/offer/{{$product->pivot->id}}'">
                  <td>{{$product->id}}</td>
                  <td>{{$product->name}}</td>
                  <td>{{$product->category->name}}</td>
                  <td>{{$product->manufacturer}}</td>
                  <td>{{$product->pivot->price}}</td>
              </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}""></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/datatables-demo.js')}}"></script>    
@endsection