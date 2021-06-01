@extends('base')
@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?r=' .uniqid()) }}"></script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Return</a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session()->has('error'))
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger" role="alert">
              <h3>Error...</h3>
            </div>
        </div>
    </div>
</div>
@endif

<form action="{{ url('backend/comentario') }}" method="post" id="createComentarioForm">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="idnoticia">Noticia</label>
        @if(isset($noticias))
          <select name="idnoticia" id="idnoticia" required class="form-control">
            <option value="" disabled selected>Selecione la Noticia</option>
              @foreach($noticias as $noticia)
                  <option value="{{ $noticia->id}}">{{ $noticia->id . ' - ' . $noticia->titulo }}</option>
              @endforeach
          </select>
        @else
            <input type="text" value="{{ $noticia->id . ' - ' . $noticia->titulo }}" class="form-control" disabled>
            <input type="hidden" id="idnoticia" name="idnoticia" value="{{ $noticia->id }}" class="form-control">
        @endif
      </div>
      <div class="form-group">
        <label for="textocomentario">Texto del Comentario</label>
        <textarea minlength="10" required class="form-control" id="textocomentario" placeholder="Texto del Comentario" name="textocomentario">{{ old('textocomentario') }}</textarea> 
      </div>
      <div class="form-group">
        <label for="email">E-Mail</label>
        <input type="email" maxlength="20" minlength="3" required class="form-control" id="email" placeholder="Autor de la Noticia" name="email" value="{{ old('email') }}">
      </div>
      <div class="form-group">
        <label for="fechacomentario">Fecha de Publicación del Comentario</label>
        <input type="date" required class="form-control" id="fechacomentario" name="fechacomentario" value="{{ old('fechacomentario') }}"></input>
      </div>
  </div>
    <!-- /.card-body -->
  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
@endsection             