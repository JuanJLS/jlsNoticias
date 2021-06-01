@extends('base')
@section('content')
@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?r=' .uniqid()) }}"></script>
@endsection

<form id="formDelete" action="{{ url('backend/comentario/' . $comentario->id) }}" method="post">
    @method('delete')
    @csrf
</form>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
             <div class="card">
                <div class="card-body">
                    <a href="{{ route('backend.comentario.edit', ['comentario' => $comentario]) }}" class="btn btn-primary">Editar comentario</a>
                    <a href="{{ route('backend.comentario.create') }}" class="btn btn-primary">Crear Nuevo comentario</a>
                    <a href="{{ route('backend.comentario.index') }}" class="btn btn-primary">Return</a>
                    <a href="#" data-table="Comentario" data-id="{{ $comentario->id }}" data-name="{{ $comentario->email }}" class="btn btn-danger" id="enlaceBorrar">Borrar comentario</a>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th>
                <h1>Comentario</h1>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Texto de la Comentario</td>
            <td><textarea readonly class="comentario-textarea">{{ $comentario->textocomentario }}</textarea></td>
        </tr>
        <tr>
            <td>Autor del Comentario</td>
            <td>{{ $comentario->email }}</td>
        </tr>
        <tr>
            <td>Fecha de Publicación del Comentario</td>
            <td>{{ date("d-m-Y", strtotime($comentario->fechacomentario)) }}</td>
        </tr>
    </tbody>
</table>

@endsection('content')