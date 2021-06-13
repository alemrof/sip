@extends('layouts.master')

@section('custom-styles')
<link rel="stylesheet" href="{{asset('css/stars.css')}}">
<link rel="stylesheet" href="{{asset('css/carouselCustomStyle.css')}}">
@endsection

@section('content')
    <!-- Page Heading -->
    
    <div class="card border-dark"">
        <div class="card-header bg-dark text-white">
            <h1 class="h3 mb-2">{{$product->name}}</h1>
            <h5>
                <img class="single-star" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALNSURBVEhL1ZZBaxNREIDfbDapSUC8VFREockmtlaoB8WDiklRT0UQLXgRvfgH6kVFL+JNT968KF6EKoL0pNJGqgfRgx6k2m4SsBQVcylCE5vsvvG9lyG4ZneTl1bBDx5vZl5mJjPZzFv231F9PnBQLlK1MWjXBk3jmlykagO0a7HyIrOPue4bpUQi+5NHFt4qWYOeKgaXXyXRI+ugXXG9YI00OH9HqiJqGHtjOfs9qV2hXbHD+SUSW/jZOqFV8Wohs8vh7kdSPZhGZLAvt/CJ1I5oVewiv0xiG2FnfnRdce2lNYANnEdEk0weAMCBKGTjh+wymUIJTPxhcjKW2nplOzTQcpENiA+eRoY5OvYFGBSQsYcRYGWMgl36emNpeHy8TsceYHU2PeQ4aAmnlNBTCMwCkUjIO4Oq6xbZBbF9FjHLIqYt5JL48iXTBBtqBesc5/yu+uQ/wjCM86rV1WnrDAO8v9YKO6E6gHA2MWo/aP3GKzOpE6Ldj/5WcplUtPlUMl96onRlJX7OpI9zho8RWYJM6wIAqxoMTm7IF5+Sqf2prk1n8wjO1Holl0kBzbH46PwMmRRtiSXynkXDmBKX3yYy9QgsA+djiaPlV2Ro4ZtY0rz6+LPek8MyixjHgq7MwJGpHABvk6qP8A27p0NntfjTZ0nUppNvaGIEGCZRm06+gYnRTveJByBDqjbSV8YgtY3AxI0lGFzLMJG+MgapbQQmdhkbIdEfgDm1QgiLEdxqxD0kehAtXJRDPpkv7paLBv4iHXsIiiEJTgzsT6eKmLcT8R2Qiefse2RjUpY2eSbUStPaxCdGi+ABMp36LrZ+OfLE5X4rkYCbcKD4o3nqD75Ob6xW8aIIOkEjt5IcLW1unnrxTYyz6f6aw74I8U4cYtchN/etedIdWBjaUsO6fN++EDfZNjhc9HQiEOUo3rFI7Rn1niZikfobjP0Cbr4HU1a5R3YAAAAASUVORK5CYII=" alt="">
                @if ($product->rating == 0)
                    <span style="margin: auto">Brak ocen</span>    
                @else
                    <span style="margin: auto">{{$product->rating}}</span>        
                @endif
            </h5>
        </div>
        
        <div class="card-body">
            <!-- Wybór zakładki -->
            <ul class="nav nav-tabs card-header-tabs" id="show-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#description" role="tab" aria-controls="description" aria-selected="true">Opis</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Opinie</a>
                </li>
            </ul>
            <!-- Koniec wyboru zakładki -->
    
            {{-- Zakładki --}}
            <div class="tab-content mt-3">
                {{-- Opis --}}
                <div class="tab-pane active" id="description" role="tabpanel">
                    <div class="row">
                        {{-- Atrybuty --}}
                        <div class="col col-12 col-xl-6">
                            <ul class="list-group list-group-flush">
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
                                    <span class="mr-auto">Data utworzenia:</span>
                                    <span>{{$product->created_at}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="mr-auto">Data aktualizacji:</span>
                                    <span>{{$product->updated_at}}</span>
                                </li>
                                @auth
                                    @if (auth()->user()->isAdmin())
                                        <li class="list-group-item d-flex">
                                            <a href="{{route('products.edit', $product->id)}}" type="button" class="btn btn-light border-dark">Edytuj</a>
                                            <form action="/products/{{$product->id}}" method="POST" class="ml-2">
                                                {{csrf_field()}}
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input class="btn btn-light border-dark" type="submit" value="Usuń">
                                            </form>
                                        </li>
                                    @endif
                                @endauth
                            </ul>
                        </div>
                        {{-- Koniec atrybutów --}}
    
                        {{-- Galeria --}}
                        <div class="col col-12 col-xl-6 d-flex justify-content-center align-self-center">
                            
                            <!-- Button trigger modal -->
                            <button type="button" class="btn" data-toggle="modal" data-target="#exampleModal">
                                @if (count($images) > 0)
                                    <img src="{{asset('imgs/products/'.$images[0]->name)}}" class="img-thumbnail show-thumbnail-img" alt="...">
                                @else
                                    <p>Brak zdjęć. Dodaj pierwsze zdjęcie!</p>
                                @endif
                            </button>
                        </div>
                        {{-- Koniec galerii --}}
    
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Galeria zdjęć</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="carouselImages" class="carousel slide" data-ride="carousel" data-interval="false">
                                            <div class="carousel-inner">
                                                @if (count($images) > 0)
                                                    <div class="carousel-item active">
                                                        <img src="{{asset('imgs/products/'.$images[0]->name)}}" class="d-block w-100" alt="...">
                                                        @auth
                                                            @if (auth()->user()->isAdmin())
                                                                <form action="/products/{{$product->id}}/image/{{$images[0]->id}}" method="POST" class="ml-auto">
                                                                    {{csrf_field()}}
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <button class="btn btn-danger carousel-delete-image" type="submit">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                    @for ($i = 1; $i < count($images); $i++)
                                                        <div class="carousel-item">
                                                            <img src="{{asset('imgs/products/'.$images[$i]->name)}}" class="d-block w-100" alt="...">
                                                            @auth
                                                                @if (auth()->user()->isAdmin())
                                                                    <form action="/products/{{$product->id}}/image/{{$images[$i]->id}}" method="POST" class="ml-auto">
                                                                        {{csrf_field()}}
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button class="btn btn-danger carousel-delete-image" type="submit">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endauth
                                                        </div>    
                                                    @endfor
                                                @endif
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselImages" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Poprzednie</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselImages" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Następne</span>
                                            </a>
                                        </div>    
                                    </div>
                                    <div class="modal-footer">
                                        @auth
                                            @if (auth()->user()->isAdmin())
                                                <form action="{{ route('product.image.store', $product->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <input type="file" name="image" class="form-control">
                                                        </div>
                                                        <div class="col-md-4 d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-success border-dark ml-auto">Dodaj</button>
                                                        </div>
                                                    </div>
                                                </form>    
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Koniec modal --}}
                    </div>
                </div>
                {{-- Koniec opisu --}}
                
    
                {{-- Opinie --}}
                <div class="tab-pane" id="comments" role="tabpanel" aria-labelledby="comments-tab"> 
                    <ul class="list-group list-group-flush">
                        @if ($product->rating == 0)
                            <li class="list-group-item">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h5 class="mb-1">Ten produkt nie został jeszcze oceniony</h5>
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
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-1">{{$comment->content}}</p>
                                                @auth
                                                    @if (auth()->user()->isModerator())
                                                        <form action="/products/{{$product->id}}/comment/{{$comment->id}}" method="POST" class="ml-auto">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <button class="btn btn-outline-danger" type="submit">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>
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
                                        @if (!auth()->user()->hasProductComment($product->id))
                                        <form action="{{route('product.comment.store', $product->id)}}" method="POST">
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
                {{-- Koniec opinii --}}
            </div>
            {{-- Koniec zakładek --}}
        </div>
    </div>

@endsection

@section('custom-scripts')
    <script src="{{asset('js/show-tabs.js')}}"></script>
@endsection