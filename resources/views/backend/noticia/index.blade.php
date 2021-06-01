@extends('base')
@section('content')
@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?r=' .uniqid()) }}"></script>
    <script src="https://cdn.tiny.cloud/1/gzpyrb46bhayxozbrs4be1me39ef9jh874msotgs2xzyojcr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
        selector: 'textarea',
        readonly: 1,
        });
    </script>
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
      Búsqueda: {{ $search ?? '' }} || Campo de Ordenación: {{ $orderby ?? ''}} || De forma: {{ $sort ?? '' }} || Número de Página: {{ $noticias->currentPage() ?? '' }}
    </div>
@endisset

<table class="table table-responsive table-hover">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">
                <a href="{{route('backend.noticia.index',
                                 ['search' => $search,
                                 'sort' => 'asc',
                                 'orderby' => 0 ])}}">↓</a>
                Título
                <a href="{{route('backend.noticia.index',
                                 ['search' => $search,
                                 'sort' => 'desc',
                                 'orderby' => 0 ])}}">↑</a>
            </th>
            <th scope="col">
                <a href="{{route('backend.noticia.index',
                                 ['search' => $search,
                                 'sort' => 'asc',
                                 'orderby' => 1 ])}}">↓</a>Autor<a href="{{route('backend.noticia.index',
                                 ['search' => $search,
                                 'sort' => 'desc',
                                 'orderby' => 1 ])}}">↑</a>
            </th>
            <th scope="col">
                <a href="{{route('backend.noticia.index',
                                 ['search' => $search,
                                 'sort' => 'asc',
                                 'orderby' => 2 ])}}">↓</a>Fecha<a href="{{route('backend.noticia.index',
                                 ['search' => $search,
                                 'sort' => 'desc',
                                 'orderby' => 2 ])}}">↑</a>
            </th>
            <th scope="col">Texto de la Noticia</th>
            <th scope="col">Imagen</th>
            <th scope="col">Mostrar</th>
            <th scope="col">Ver Comentarios</th>
            <th scope="col">Editar</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        @foreach($noticias as $noticia)
            <tr>
                <td>{{ $noticia->id }}</td>
                <td>{{ $noticia->titulo }}</td>
                <td>{{ $noticia->autor }}</td>
                <td>{{ date("d-m-Y", strtotime($noticia->fechanoticia)) }}</td>
                <td><textarea class="noticia-textarea">{!! $noticia->textonoticia !!}</textarea></td>
                <td><img src="data:image/jpeg;base64,{{ $noticia->imagen }}" height="100"></td>
                <td><a href="{{ url('backend/noticia/' . $noticia->id) }}">Ver Noticia</td>
                <td><a href="{{ route('backend.comentario.showcomentarios', $noticia->id) }}">Ver Comentarios</td>
                <td><a href="{{ url('backend/noticia/'  . $noticia->id . '/edit') }}">Editar Noticia</td>
                <td><a href="#" data-table="Noticia" data-id="{{ $noticia->id }}" class="enlaceBorrar">Delete</a></td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $noticias->onEachSide(2)->links() }}
<form id="formDelete" action="{{ url('backend/noticia') }}" method="post">
    @method('delete')
    @csrf
</form>
@endsection('content')