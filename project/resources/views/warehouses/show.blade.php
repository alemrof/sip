@extends('layouts.master')

@section('custom-styles')
<link rel="stylesheet" href="{{asset('css/stars.css')}}">
@endsection

@section('content')
<!-- Page Heading -->

<div class="card border-dark"">
    <div class="card-header bg-dark text-white">
        <h1 class="h3 mb-2">{{$warehouse->name}}</h1>
        <h5>
            <img class="single-star" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALNSURBVEhL1ZZBaxNREIDfbDapSUC8VFREockmtlaoB8WDiklRT0UQLXgRvfgH6kVFL+JNT968KF6EKoL0pNJGqgfRgx6k2m4SsBQVcylCE5vsvvG9lyG4ZneTl1bBDx5vZl5mJjPZzFv231F9PnBQLlK1MWjXBk3jmlykagO0a7HyIrOPue4bpUQi+5NHFt4qWYOeKgaXXyXRI+ugXXG9YI00OH9HqiJqGHtjOfs9qV2hXbHD+SUSW/jZOqFV8Wohs8vh7kdSPZhGZLAvt/CJ1I5oVewiv0xiG2FnfnRdce2lNYANnEdEk0weAMCBKGTjh+wymUIJTPxhcjKW2nplOzTQcpENiA+eRoY5OvYFGBSQsYcRYGWMgl36emNpeHy8TsceYHU2PeQ4aAmnlNBTCMwCkUjIO4Oq6xbZBbF9FjHLIqYt5JL48iXTBBtqBesc5/yu+uQ/wjCM86rV1WnrDAO8v9YKO6E6gHA2MWo/aP3GKzOpE6Ldj/5WcplUtPlUMl96onRlJX7OpI9zho8RWYJM6wIAqxoMTm7IF5+Sqf2prk1n8wjO1Holl0kBzbH46PwMmRRtiSXynkXDmBKX3yYy9QgsA+djiaPlV2Ro4ZtY0rz6+LPek8MyixjHgq7MwJGpHABvk6qP8A27p0NntfjTZ0nUppNvaGIEGCZRm06+gYnRTveJByBDqjbSV8YgtY3AxI0lGFzLMJG+MgapbQQmdhkbIdEfgDm1QgiLEdxqxD0kehAtXJRDPpkv7paLBv4iHXsIiiEJTgzsT6eKmLcT8R2Qiefse2RjUpY2eSbUStPaxCdGi+ABMp36LrZ+OfLE5X4rkYCbcKD4o3nqD75Ob6xW8aIIOkEjt5IcLW1unnrxTYyz6f6aw74I8U4cYtchN/etedIdWBjaUsO6fN++EDfZNjhc9HQiEOUo3rFI7Rn1niZikfobjP0Cbr4HU1a5R3YAAAAASUVORK5CYII=" alt="">
            @if ($warehouse->rating == 0)
                <span style="margin: auto">Brak ocen</span>    
            @else
                <span style="margin: auto">{{$warehouse->rating}}</span>        
            @endif
        </h5>
        <ul class="nav nav-tabs card-header-tabs" id="warehouse-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#description" role="tab" aria-controls="description" aria-selected="true">Opis</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Opinie</a>
          </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content mt-3">
        {{-- Description --}}
            <div class="tab-pane active" id="description" role="tabpanel">
                <ul class="list-group list-group-flush">
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
            
        {{-- comments --}}
            <div class="tab-pane" id="comments" role="tabpanel" aria-labelledby="comments-tab"> 
                <ul class="list-group list-group-flush">
                    @if ($warehouse->rating == 0)
                        <li class="list-group-item">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="mb-1">Ten magazyn nie został jeszcze oceniony</h5>
                                </li>
                                <div class="hl"></div>
                            </ul>
                        </li>    
                    @else
                        <li class="list-group-item">
                            <ul class="list-group">
                                @foreach ($comments as $comment)
                                    <li class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{$comment->user->name}}</h5>
                                            <small class="text-muted">{{$comment->created_at}}</small>
                                        </div>
                                        <p class="starability-result" data-rating="{{$comment->rating}}">
                                            Oceniono na: {{$comment->created_at}} gwiazdki
                                        </p>
                                        <p class="mb-1">{{$comment->content}}</p>
                                        @auth
                                            @if (auth()->user()->isModerator())
                                                <form action="/warehouses/{{$warehouse->id}}/comment/{{$comment->id}}" method="POST" class="ml-auto">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-outline-danger" type="submit">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth
                                    </li>
                                    <div class="hl"></div>
                                @endforeach
                            </ul>
                        </li>    
                    @endif
                    <div class="hl"></div>
                    <div class="hl"></div>
                    <li class="list-group-item">
                        <ul class="list-group">
                            <li class="list-group-item">
                                @auth
                                    @if (!auth()->user()->hasComment($warehouse->id))
                                    <form action="{{route('comment.store', $warehouse->id)}}" method="POST">
                                        {{csrf_field()}}
                            
                                        {{-- Komentarz --}}
                                        <h5 class="mb-1">Dodaj opinię</h5>
                                        <fieldset class="starability-basic">
                                            <input type="radio" id="no-rate" class="input-no-rate" name="rating" value="0" checked aria-label="No rating." />
                                            <input type="radio" id="first-rate1" name="rating" value="1" />
                                            <label for="first-rate1" title="Bardzo słaby">1 star</label>
                                            <input type="radio" id="first-rate2" name="rating" value="2" />
                                            <label for="first-rate2" title="Słaby">2 stars</label>
                                            <input type="radio" id="first-rate3" name="rating" value="3" />
                                            <label for="first-rate3" title="Przeciętny">3 stars</label>
                                            <input type="radio" id="first-rate4" name="rating" value="4" />
                                            <label for="first-rate4" title="Dobry">4 stars</label>
                                            <input type="radio" id="first-rate5" name="rating" value="5" />
                                            <label for="first-rate5" title="Bardzo dobry">5 stars</label>
                                        </fieldset>
                                        
                                        <textarea name="content" rows="1" placeholder="Podziel się swoją opinią..." style="width: 100%; height: 50px;"></textarea>
                                        <input type="submit" class="btn btn-primary mt-2" value="Publikuj">
                                        {{-- </div> --}}
                                    </form>
                                    @endif
                                @endauth
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-scripts')
    <script src="{{asset('js/warehouse-tabs.js')}}"></script>
@endsection