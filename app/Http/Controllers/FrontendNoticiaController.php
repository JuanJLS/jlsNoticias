<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Http\Request;
use DB;

class FrontendNoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    
        $noticias = new Noticia();
        $search = $request->input('search');
        if($search != null) {
            $noticias = $noticias->where('titulo', 'like', '%' . $search . '%')
                                 ->orWhere('autor', 'like', '%' . $search . '%')
                                 ->orWhere('fechanoticia', 'like', '%' . $search . '%')
                                 ->orWhere('textonoticia', 'like', '%' . $search . '%');
        }
        
        $orderby = 'fechanoticia';
        $sort = 'asc';
        
        $noticias = $noticias->orderBy($orderby, $sort);
        $paginationParameters = ['search' => $search, 'orderby' => $orderby, 'sort' => $sort];
        $noticias = $noticias->orderBy('fechanoticia', 'asc')->paginate(3)->appends($paginationParameters);
        if($orderby == 'fechanoticia') {
            $order = 'Fecha de la Noticia';
        } else {
            $order = $orderby;
        }
        if($sort === 'asc') {
            $sortForm = 'Ascendente';
        } else {
            $sortForm = $sort; 
        }
        //$result = DB::select('select noticia.id, noticia.titulo, COUNT(comentario.id) from noticia left join comentario on noticia.id = comentario.idnoticia  GROUP BY noticia.id ,noticia.titulo order by fechanoticia asc, fechanoticia asc limit 3 offset 0');
        return view('frontend.noticia.index', array_merge(['noticias' => $noticias, 'order' => $order, 'sortForm' => $sortForm], $paginationParameters));
                                                            
                                                            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia)
    {
        $id = $noticia->id;
        $comentarios = Comentario::where('idnoticia', $id)
                                    ->orderBy('fechacomentario', 'asc')
                                    ->get();
        return view('frontend.noticia.show', ['noticia' => $noticia, 'comentarios' =>$comentarios]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $noticia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noticia $noticia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    {
        //
    }
}
