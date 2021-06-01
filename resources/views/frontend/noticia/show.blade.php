@extends('basefrontend')
@section('content')
@section('postscript')
    <script src="{{ url('assets/frontend/js/script.js?r=' .uniqid()) }}"></script>
@endsection('postscript')
@if(session()->has('op'))
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success" role="alert">
                {{ session()->get('op')}}
            </div>
        </div>
    </div>
</div>
@endif

    <article class="entry">
      <div class="entry-img">
        <!--<img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">-->
      </div>
      <h2 class="entry-title">
        <a href="#">{{ $noticia->titulo }}</a>
      </h2>
      <div class="entry-meta">
        <ul>
          <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="{{route('frontend.noticia.index',
                                 ['search' => $noticia->autor ])}}">{{ $noticia->autor}}</a></li>
          <li class="d-flex align-items-center"><i class="bi bi-calendar"></i> <a href="{{route('frontend.noticia.index',
                                 ['search' => $noticia->fechanoticia ])}}"><time datatime="{{ $noticia->fechanoticia}}">{{ date("d-m-Y", strtotime($noticia->fechanoticia)) }}</time></a></li>
          <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="#createComentarioForm">{{ App\Models\Comentario::where('idnoticia', '=', $noticia->id)->count() }}</a></li>
        </ul>
      </div>
      <div class="entry-content">
          <img src="data:image/jpeg;base64,{{ $noticia->imagen }}" class="noticia-img">
        <p class="noticia-texto">{!! $noticia->textonoticia !!}</p>
        <div class="read-more">
          <!--<a href="blog-single.html"></a>-->
        </div>
      </div>
      
    <div class="blog-comments">
        <h4 class="comments-count">{{ App\Models\Comentario::where('idnoticia', '=', $noticia->id)->count() }} Comment(s)</h4>
        @foreach($comentarios as $comentario)    
            <div id="comment-1" class="comment">
              <div class="d-flex">
                <div><h5><a href="#">{{ $comentario->email }}</a></h5>
                  <time>{{ date("d-m-Y", strtotime($comentario->fechacomentario)) }}</time>
                  <p class="comment-text">{{ $comentario->textocomentario }}</p>
                  <button class="delete-comment"><a href="#" data-table="Comentario" data-id="{{ $comentario->id }}" class="enlaceBorrar">Borrar Comentario</a></button>
                </div>
              </div>
            </div><!-- End comment #1 -->
        @endforeach
    </div>
        
  <form action="{{ url('frontend/comentario') }}" method="post" id="createComentarioForm">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="idnoticia"><h3>Nuevo Comentario</h3></label>
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
          <input type="email" maxlength="50" minlength="3" required class="form-control" id="email" placeholder="Autor del Comentario" name="email" value="{{ old('email') }}">
      </div>
      <div class="form-group">
        <label for="fechacomentario">Fecha de Publicación del Comentario</label>
          <input type="date" required class="form-control" id="fechacomentario" name="fechacomentario" value="{{ date("Y-m-d") }}" readonly></input>
      </div>
    </div>
      <!-- /.card-body -->
    <button type="submit" class="btn btn-primary add-comment-bt">Añadir Comentario</button>
  </form>
</article><!-- End blog entry -->
<form id="formDelete" action="{{ url('frontend/comentario') }}" method="post">
    @method('delete')
    @csrf
</form>
@endsection  