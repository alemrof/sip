<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SIP - składy budowlane</title>

  <!-- Bootstrap core CSS -->
  {{-- <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}"> --}}
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="{{asset('css/blog-home.css')}}">

  <!-- OpenLayer Map -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" type="text/css">
  <style>
    .map {
      height: 400px;
      width: 100%;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>

</head>

<body class="d-flex flex-column vh-100">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="{{route('home')}}">Składy budowlane</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="{{route('home')}}">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          @if (Auth::check())
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.index')}}">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/logout">Wylogowywanie</a>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="/login">Logowanie</a>
            </li>    
            <li class="nav-item">
              <a class="nav-link" href="/register">Rejestracja</a>
            </li>
          @endif
          
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <div class="col-md-12">

        @yield('content')

      </div>

      {{-- <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

      </div> --}}

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark mt-auto">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('js/home.js')}}"></script>

</body>

</html>
