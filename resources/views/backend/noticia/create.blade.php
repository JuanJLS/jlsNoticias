@extends('base')
@section('postscript')
    <script src="{{ url('assets/backend/js/script.js?r=' .uniqid()) }}"></script>
     <script src="https://cdn.tiny.cloud/1/gzpyrb46bhayxozbrs4be1me39ef9jh874msotgs2xzyojcr/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
      tinymce.init({
      selector: '#textonoticia',
      });
  </script>
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

<form action="{{ url('backend/noticia') }}" method="post" id="createNoticiaForm" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="titulo">Título</label>
        @error('titulo')
          <div class="alert alert-danger">{{ $message }} </div>
        @enderror
        <input type="text" maxlength="100" minlength="4" required class="form-control" id="titulo" placeholder="Título de la Noticia" name="titulo" value="{{ old('titulo') }}">
      </div>
      <div class="form-group">
        <label for="textonoticia">Texto de la Noticia</label>
          @error('textonoticia')
            <div class="alert alert-danger">{{ $message }} </div>
          @enderror
        <textarea minlength="50" class="form-control" id="textonoticia" placeholder="Texto de la Noticia" name="textonoticia">{{ old('textonoticia') }}</textarea> 
      </div>
      <div class="form-group">
        <label for="imagen">Imagen de la Noticia</label>
          @error('imagen')
            <div class="alert alert-danger">{{ $message }} </div>
          @enderror
        <input type="file" required class="form-control" placeholder="Seleccione la imagen a subir" id="imagen" name="imagen" value="{{ old('imagen') }}">
      </div>
      <div class="form-group">
        <label for="autor">Autor</label>
          @error('autor')
            <div class="alert alert-danger">{{ $message }} </div>
          @enderror
        <input type="text" maxlength="30" minlength="3" required class="form-control" id="autor" placeholder="Autor de la Noticia" name="autor" value="{{ old('autor') }}">
      </div>
      <div class="form-group">
        <label for="fechanoticia">Fecha de Publicación</label> 
          @error('fechanoticia')
            <div class="alert alert-danger">{{ $message }} </div>
          @enderror
        <input type="date" required class="form-control" id="fechanoticia" name="fechanoticia" value="{{ old('fechanoticia') }}"></input>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@endsection
