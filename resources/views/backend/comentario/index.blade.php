@extends('base')
@section('content')
@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?r=' .uniqid()) }}"></script>
@endsection('postscript')

@if(session()->has('op'))
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success" role="alert">
                Operation: {{ session()->get('op')}} | ID: {{ Session::get('id')}} | Result: {{ session()->get('result') }}
            </div>
        </div>
    </div>
</div>
@endif

@isset($search) 
    <div class="alert alert-primary" role="alert">
        Búsqueda: {{ $search ?? ''}} || Campo de Ordenación: {{ $orderby ?? ''}} || De forma: {{ $sort ?? '' }} || Número de Página: {{ $comentarios->currentPage() ?? '' }}
    </div>
@endisset

<table class="table table-responsive table-hover">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">#id de la Noticia</th>
            <th scope="col">
                <a href="{{route('backend.comentario.index',
                                 ['search' => $search ?? '',
                                 'sort' => 'asc',
                                 'orderby' => 0 ])}}">↓</a>
                Texto del Comentario
                <a href="{{route('backend.comentario.index',
                                 ['search' => $search ?? '',
                                 'sort' => 'desc',
                                 'orderby' => 0 ])}}">↑</a>
            </th>
            <th scope="col">
                <a href="{{route('backend.comentario.index',
                                 ['search' => $search ?? '',
                                 'sort' => 'asc',
                                 'orderby' => 1 ])}}">↓</a>Fecha del Comentario<a href="{{route('backend.comentario.index',
                                 ['search' => $search ?? '',
                                 'sort' => 'desc',
                                 'orderby' => 1 ])}}">↑</a>
            </th>
            <th scope="col">
                <a href="{{route('backend.comentario.index',
                                 ['search' => $search ?? '',
                                 'sort' => 'asc',
                                 'orderby' => 2 ])}}">↓</a>Email<a href="{{route('backend.comentario.index',
                                 ['search' => $search ?? '',
                                 'sort' => 'desc',
                                 'orderby' => 2 ])}}">↑</a>
            </th>
            <th scope="col">Show</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($comentarios as $comentario)
            <tr>
                <td>{{ $comentario->id }}</td>
                <td>{{ $comentario->idnoticia }}</td>
                <td><textarea readonly class="comentario-textarea">{{ $comentario->textocomentario }}</textarea></td>
                <td>{{ date("d-m-Y", strtotime($comentario->fechacomentario)) }}</td>
                <td>{{ $comentario->email }}</td>
                <td><a href="{{ url('backend/comentario/' . $comentario->id) }}">Ver comentario</td>
                <td><a href="{{ url('backend/comentario/'  . $comentario->id . '/edit') }}">Editar comentario</td>
                <td><a href="#" data-table="Comentario" data-id="{{ $comentario->id }}" class="enlaceBorrar">Delete</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $comentarios->onEachSide(2)->links() }}
<form id="formDelete" action="{{ url('backend/comentario') }}" method="post">
    @method('delete')
    @csrf
</form>
@endsection('content')