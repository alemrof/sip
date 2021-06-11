@extends('layouts.master')

@section('custom-styles')
  <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">    
@endsection

@section('content')
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Lista użytkowników</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-sm" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nazwa</th>
              <th>Rola</th>
              <th>Data rejestracji</th>
              <th>Ostatnia aktualizacja</th>
              <th>Usuń</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Id</th>
              <th>Nazwa</th>
              <th>Rola</th>
              <th>Data rejestracji</th>
              <th>Ostatnia aktualizacja</th>
              <th>Usuń</th>
            </tr>
          </tfoot>
          <tbody>
            @foreach ($users as $user)
              <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td>
                    <form class="d-flex justify-content-between" action="/users/{{$user->id}}" method="POST">
                      {{csrf_field()}}
                      <input type="hidden" name="_method" value="PUT">
                      <select class="form-control form-control-sm" id="role" name="role_id">
                        @foreach ($roles as $role)
                          @if ($role->id === $user->role->id)
                            <option selected value="{{$role->id}}">{{$role->name}}</option>
                          @else
                            <option value="{{$role->id}}">{{$role->name}}</option>
                          @endif
                        @endforeach
                      </select>
                      <button class="btn btn-sm btn-primary carousel-delete-image ml-1" type="submit">
                        <i class="far fa-save"></i>
                      </button>
                    </form>
                  </td>
                  <td>{{$user->created_at}}</td>
                  <td>{{$user->updated_at}}</td>
                  <td>
                    <form action="/users/{{$user->id}}" method="POST">
                      {{csrf_field()}}
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn btn-sm btn-danger carousel-delete-image" type="submit">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </form>
                  </td>
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