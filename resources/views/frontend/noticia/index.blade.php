@extends('basefrontend')
@section('content')
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

@isset($search) 
    <div class="alert alert-primary" role="alert">
      Búsqueda: {{ $search ?? ''}} || Campo de Ordenación: {{ $order ?? ''}} || De forma: {{ $sortForm ?? '' }}
    </div>
@endisset

    @foreach($noticias as $noticia)
        <article class="entry">
          <div class="entry-img">
            <img src="assets/img/blog/blog-1.jpg" alt="" class="img-fluid">
          </div>
          <h2 class="entry-title">
            <a href="{{ route('frontend.noticia.show', $noticia)}}" target="_blank">{{ $noticia->titulo }}</a>
          </h2>
          <div class="entry-meta">
            <ul>
              <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="{{route('frontend.noticia.index',
                                 ['search' => $noticia->autor ])}}">{{ $noticia->autor}}</a></li>
              <li class="d-flex align-items-center"><i class="bi bi-calendar"></i> <a href="{{route('frontend.noticia.index',
                                 ['search' => $noticia->fechanoticia ])}}"><time datetime="{{ date("Y-m-d", strtotime($noticia->fechanoticia)) }}">{{ date("d-m-Y", strtotime($noticia->fechanoticia)) }}</time></a></li>
              <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="#">{{ $numero = App\Models\Comentario::where('idnoticia', '=', $noticia->id)->count() }}</a></li>
            </ul>
          </div>
          <div class="entry-content">
            <p class="noticia-texto">
              {!! Str::limit($noticia->textonoticia, 1000) !!}
            </p>
            <div class="read-more"></div>
            <div class="read-more">
              <a href="{{ route('frontend.noticia.show', $noticia)}}" target="_blank">Seguir leyendo</a>
            </div>
          </div>
        </article><!-- End blog entry -->
    @endforeach
{{ $noticias->onEachSide(2)->links() }}
@endsection            