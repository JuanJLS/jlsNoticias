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
              <h3>{{ $error }}</h3>
            </div>
        </div>
    </div>
</div>
@endif

<form action="{{ route('backend.comentario.update', $comentario->id) }}" method="post" id="editComentarioForm">
    @csrf
    @method('put')
    <div class="card-body">
      <div class="form-group">
        <label for="idnoticia">Noticia</label>
        
        <select readonly name="idcomentario" id="idcomentario" required class="form-control">
            <option value="" disabled >Select comentario</option>
                @foreach($noticias as $noticia)
                    @if($noticia->id == old('idnoticia', $comentario->idnoticia))
                        <option selected value="{{ $noticia->id}}" disabled>{{ $noticia->id . ' - ' . $noticia->titulo }}</option>
                    @else
                        <option value="{{ $noticia->id}}" disabled>{{ $noticia->id . ' - ' . $noticia->titulo }}</option>
                    @endif
                @endforeach
          </select>
        
      </div>
      <div class="form-group">
        <label for="textocomentario">Texto del Comentario</label>
        <textarea minlength="10" required class="form-control" id="textocomentario" placeholder="Texto del Comentario" name="textocomentario">{{ old('textocomentario', $comentario->textocomentario) }}</textarea> 
      </div>
      <div class="form-group">
        <label for="email">E-Mail</label>
        <input type="email" maxlength="50" minlength="3" required class="form-control" id="email" placeholder="Autor de la Noticia" name="email" value="{{ old('email', $comentario->email) }}">
      </div>
      <div class="form-group">
        <label for="fechacomentario">Fecha de Publicación del Comentario</label>
        <input type="date" required class="form-control" id="fechacomentario" name="fechacomentario" value="{{ old('fechacomentario', $comentario->fechacomentario) }}"></input>
      </div>
  </div>
    <!-- /.card-body -->
  <div class="card-footer">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>
@endsection             