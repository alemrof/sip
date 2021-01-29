@extends('layouts.master')

@section('custom-styles')
        
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Wyświetlanie produktu</h1>
    {{-- <p class="mb-4">Wypełnij wszystkie pola formularza</p> --}}
    <div class="row">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <ul class="list-group">
                <li class="list-group-item active bg-dark">{{$product->name}}</li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Id:</span>
                    <span>{{$product->id}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Kategoria:</span>
                    <span>{{$product->category->name}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Producent:</span>
                    <span>{{$product->manufacturer}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Cena:</span>
                    <span>{{$product->pivot->price}}</span>
                </li>
                @auth
                    @if (auth()->user()->isAdmin())
                        <li class="list-group-item d-flex">
                            <a href="{{route('offers.edit', [$warehouse->id, $product->pivot->id])}}" type="button" class="btn btn-light border-dark">Edytuj cenę</a>
                            <form action="{{route('offers.destroy', [$warehouse->id, $product->id])}}" method="POST" class="ml-auto">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <input class="btn btn-light border-dark" type="submit" value="Usuń">
                            </form>
                        </li>     
                    @endif
                @endauth
            </ul>
        </div>
    </div>

@endsection

@section('custom-scripts')
        
@endsection