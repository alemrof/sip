@extends('layouts.master')

@section('custom-styles')
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Lista produktów</h1>
    <p class="mb-4">Naciśnij wiersz aby wyświetlić wpis</p>

    <!-- DataTale -->
    <div class="card shadow mb-4">
        @auth
            @if (auth()->user()->isAdmin())
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <a href="{{route('products.create')}}">
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
                        <th>Pokaż na mapie</th>
                        <th>Nazwa</th>
                        <th>Producent</th>
                        <th>Kategoria</th>
                        <th>Cena</th>
                        <th>Sieć</th>
                        <th>Nr Magazynu</th>
                        <th>Dystans [m]</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Pokaż na mapie</th>
                        <th>Nazwa</th>
                        <th>Producent</th>
                        <th>Kategoria</th>
                        <th>Cena</th>
                        <th>Sieć</th>
                        <th>Nr Magazynu</th>
                        <th>Dystans [m]</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @for ( $j=0; $j<sizeof($products);$j++)
                        <tr onclick="window.location='/products/{{$products[$j]->id}}'">
                            <td><a href="{{route("home",['id'=>$products[$j]->warehouse_id])}}"><img src="/imgs/warehouse-icon-20px.png"></a></td>
                            <td>{{$products[$j]->name}}</td>
                            <td>{{$products[$j]->manufacturer}}</td>
                            <td>{{$products[$j]->category}}</td>
                            <td>{{$products[$j]->price}}</td>
                            <td>{{$products[$j]->company}}</td>
                            <td>{{$products[$j]->warehouse_id}}</td>
                            <td id="{{$j}}"></td>
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('js/datatables-demo.js')}}"></script>
    <script>
        let products = JSON.parse('{!! json_encode($products) !!}');
        let quantity = products.length;
        let Dist= [];
        for (let i =0; i<quantity;i++)             {
            let warehouseCoordinates = [products[i].x,products[i].y];
                        Dist[i]=ol.sphere.getDistance(userCoordinates, [products[i].x,products[i].y]);

                        let req = new XMLHttpRequest();
                        req.open('POST', "https://api.openrouteservice.org/v2/directions/driving-car");

                        req.setRequestHeader('Accept', 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8');
                        req.setRequestHeader('Content-Type', 'application/json');
                        req.setRequestHeader('Authorization', '5b3ce3597851110001cf6248d497e3ae60ae4e0da2dddd72b6f0a3ac');

                        req.onreadystatechange = function () {
                            if (this.readyState === 4) {
                                let result = JSON.parse(this.responseText);
                                console.log(result);
                                Dist[i] = result.routes[0].summary.distance;
                                document.getElementById(i.toString()).innerText = Dist[i];
                            }
                        };
                        const body = `{"coordinates":[[${userCoordinates[0]}, ${userCoordinates[1]}],[${warehouseCoordinates[0]},${warehouseCoordinates[1]}]]}`;
                        req.send(body);

        }

    </script>

@endsection
