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
@endsection

<form id="formDelete" action="{{ url('backend/noticia/' . $noticia->id) }}" method="post">
    @method('delete')
    @csrf
</form>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
             <div class="card">
                <div class="card-body">
                    <a href="{{ route('backend.noticia.edit', ['noticia' => $noticia]) }}" class="btn btn-primary">Editar Noticia</a>
                    <a href="{{ route('backend.noticia.create') }}" class="btn btn-primary">Crear Nueva Noticia</a>
                    <a href="{{ route('backend.noticia.index') }}" class="btn btn-primary">Return</a>
                    <a href="#" data-table="Noticia" data-id="{{ $noticia->id }}" data-name="{{ $noticia->titulo }}" class="btn btn-danger" id="enlaceBorrar">Borrar Noticia</a>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th>
                <h1>Noticia</h1>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Título de la Noticia</td>
            <td>{{ $noticia->titulo }}</td>
        </tr>
        <tr>
            <td>Texto de la Noticia</td>
            <td><textarea class="noticia-textarea">{!! $noticia->textonoticia !!}</textarea></td>
        </tr>
        <tr>
            <td>Imagen de la Noticia</td>
            <td><img src="data:image/jpeg;base64,{{ $noticia->imagen }}" height="100"></td>
        </tr>
        <tr>
            <td>Autor de la Noticia</td>
            <td>{{ $noticia->autor }}</td>
        </tr>
        <tr>
            <td>Fecha de Publicación de la Noticia</td>
            <td>{{ date("d-m-Y", strtotime($noticia->fechanoticia)) }}</td>
        </tr>
    </tbody>
</table>

@endsection('content')