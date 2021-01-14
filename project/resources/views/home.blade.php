<x-home-master>
@section('content')
  <script>
    // var warehouses = '{!! json_encode($warehouses) !!}';
    var warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
    console.log(warehouses);
  </script>

  <div id="map" class="map mt-3 border border-dark" style="height: 700px"></div>
  <div class="my-1">
    <button class="btn btn-info" id="addWarehouse">Dodaj skład</button>
    <button class="btn btn-danger" id="stopDrawing">Zatrzymaj rysowanie</button>
  </div>
    <!-- Okienko z atrybutami składu budowlanego -->
    <div class="card" id="popup" style="width: 20rem;">
      <div class="card-header">
        <span id="warehouse-name">Nazwa składu</span>
        <button type="button" class="close" id="closer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item" id="warehouse-company">Sieć sklepów</li>
        <li class="list-group-item" id="warehouse-adress">Aleja Grunwaldzka 102, 81-045 Gdańsk</li>
        <li class="list-group-item" id="warehouse-location">Położenie</li>
      </ul>
      <div class="card-body">
        <a href="#" class="card-link">Produkty</a>
      </div>
    </div>
  
@endsection

</x-home-master>
