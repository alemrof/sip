@extends('layouts.master')

@section('custom-styles')
        
@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Wyświetlanie składu budowlanego</h1>
{{-- <p class="mb-4">Wypełnij wszystkie pola formularza</p> --}}
<div class="row">
    <div class="col-md-10 col-lg-8 col-xl-6">
        <ul class="list-group">
            <li class="list-group-item active bg-dark">{{$warehouse->name}}</li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="mr-auto">Id:</span>
                <span>{{$warehouse->id}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="mr-auto">Sieć sklepów:</span>
                <span>{{$warehouse->company->name}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="mr-auto">Adres:</span>
                <span>{{$warehouse->address}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="mr-auto">Współrzędne:</span>
                <span>{{$warehouse->location}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="mr-auto">Data utworzenia:</span>
                <span>{{$warehouse->created_at}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <span class="mr-auto">Data aktualizacji:</span>
                <span>{{$warehouse->updated_at}}</span>
            </li>
            <div class="hl"></div>
            <li class="list-group-item d-flex">
                <a href="{{route('offers.index', $warehouse->id)}}" type="button" class="btn btn-light border-dark">Oferta</a>
                <a href="{{route('home', ['id' => $warehouse->id])}}" type="button" class="btn btn-light border-dark ml-2"><i class="fas fa-map-marked-alt"></i></a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{route('warehouses.edit', $warehouse->id)}}" type="button" class="btn btn-light border-dark ml-2">Edytuj</a>
                        <a href="{{route('warehouses.editMap', $warehouse->id)}}" type="button" class="btn btn-light border-dark ml-2">Edytuj współrzędne</a>
                        <form action="/warehouses/{{$warehouse->id}}" method="POST" class="ml-auto">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE">
                            <input class="btn btn-light border-dark" type="submit" value="Usuń">
                        </form>
                    @endif
                @endauth
            </li>    
        </ul>
    </div>
</div>

@endsection

@section('custom-scripts')
        
@endsection