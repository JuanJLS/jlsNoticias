@extends('base')
@section('content')
@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?r=' .uniqid()) }}"></script>
@endsection

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('backend.user.create')}}" class="btn btn-primary">Create User</a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session()->has('op'))
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success" role="alert">
                Operation: {{ session()->get('op')}} | ID: {{ Session::get('id')}} | Result: {{ session()->get('r') }}
            </div>
        </div>
    </div>
</div>
@endif

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
                <th scope="col">Edit</th>
             @if(Auth::id() == 1)
                <th scope="col">Delete</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                @if(Auth::id() == 1 || Auth::id() == $user->id )
                    <td><a href="{{ url('backend/usuario/'. $user->id) .'/edit' }}">Edit</a></td>
                @endif
                @if(Auth::id() == 1)
                    <td><a href="#" data-table="user" data-id="{{ $user->id }}" class="enlaceBorrar">Delete</a></td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
<form id="formDelete" action="{{ url('backend/usuario') }}" method="post">
    @method('delete')
    @csrf
</form>
@endsection('content')