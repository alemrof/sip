@extends('layouts.master')

@section('topbar-search')
<!-- Topbar Search -->

@endsection

@section('content')

<script>
  let products = JSON.parse('{!! json_encode($products) !!}');
  let names = products.map(products => products.name);
  let warehouses = JSON.parse('{!! json_encode($warehouses) !!}');
</script>

<form name="product-search-form" class=" mr-auto ml-md-3 my-2 my-md-0 mw-100 "id="product-search-form" method="get" action="/search/showProducts" >

  <div class="col-md-6">
    <div class="form-group">
      <label for="sel1">Kategoria Produktu</label>
      <select class="form-control" id="sel1" name="cat" onchange="return ajx(this)">
        @foreach ($categories as $category)
            <option>{{$category->name}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="sel2">Sieć</label>
      <select class="form-control" id="sel2" name="comp" onchange="return ajx(this)" >
        @foreach ($companies as $company)
            <option>{{$company->name}}</option>
        @endforeach
        <option>Dowolna</option>
      </select>
    </div>


  <div >
    <div class="form-group ui-widget">
      <label >Produkt</label>
      <input type="text" id="product-search-name" class="form-control bg-white  border-1 small"  name="name" aria-label="Search" aria-describedby="basic-addon2" >
      <input type="hidden" name="id" id="secret">
    </div>
    <button class="btn btn-dark" type="submit" id="product-search-button">
      <i class="fas fa-search fa-sm"></i>
    </button>
  </div>
  </div>
</form>


@endsection

@section('custom-scripts')
    <script src="{{asset('js/map.js')}}"></script>
    <script src="{{asset('js/warehouse-card.js')}}"></script>
    <script src= "https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
    <script>
        function ajx() {
            let formData = {
                cat: jQuery('#sel1').val(),
                comp: jQuery('#sel2').val(),
                _token : '<?php echo csrf_token() ?>',
            };
            $.ajax({
                type:'POST',
                url:'/search',
                dataType: 'json',
                data: formData,
                success: function (data) {
                    products = data;
                    names = products.map(products => products.name);
                    $("#product-search-name").autocomplete({
                        source: names,
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    </script>


<script>
$(function () {
    let list = names;
      $("#product-search-name").autocomplete({
          source: list,
      });
  });
</script>

@endsection







