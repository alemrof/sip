@extends('layouts.master')

@section('custom-styles')
        
@endsection

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Wyświetlanie sieci sklepów</h1>
    {{-- <p class="mb-4">Wypełnij wszystkie pola formularza</p> --}}
    <div class="row">
        <div class="col-md-10 col-lg-8 col-xl-6">
            <ul class="list-group">
                <li class="list-group-item active bg-dark">{{$company->name}}</li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Id:</span>
                    <span>{{$company->id}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data utworzenia:</span>
                    <span>{{$company->created_at}}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="mr-auto">Data aktualizacji:</span>
                    <span>{{$company->updated_at}}</span>
                </li>
                @auth
                    @if (auth()->user()->isAdmin())
                        <li class="list-group-item d-flex">
                            <a href="{{route('companies.edit', $company->id)}}" type="button" class="btn btn-light border-dark">Edytuj</a>
                            <form action="/companies/{{$company->id}}" method="POST" class="ml-2">
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