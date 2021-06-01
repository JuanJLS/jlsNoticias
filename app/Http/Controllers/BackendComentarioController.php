<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Http\Request;

class BackendComentarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = ['textocomentario', 'fechacomentario', 'email'];
        $comentarios = new Comentario();
        $search = $request->input('search');
        if($search != null){
            $comentarios = $comentarios->where('textocomentario', 'like', '%' . $search . '%')
                                        ->orWhere('fechacomentario', 'like', '%' . $search . '%')
                                        ->orWhere('email', 'like', '%' . $search . '%');
        }
        $orderby = $request->input('orderby');
        $sort = 'asc';
        if($orderby != null) {
            if(isset($order[$orderby])) {
                $orderby = $order[$orderby];
            } else {
                $oderby = $order[1];
            }
            if($request->input('sort') != null) {
                $sort = $request->input('sort');
            }
            $comentarios = $comentarios->orderBy($orderby, $sort);
        }
        $paginationParameters = ['search' => $search, 'orderby' => $orderby, 'sort' => $sort];
        $comentarios = $comentarios->orderBy('fechacomentario', 'desc')->paginate(5)->appends($paginationParameters);
        return view('backend.comentario.index', array_merge(['comentarios' => $comentarios], $paginationParameters));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $noticias = Noticia::all();
        return view('backend.comentario.create', ['noticias' => $noticias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comentario = new Comentario($request->all());
        try {
            $result = $comentario->save();
        } catch (\Exception $e) {
            $result = 0;
        }
        if($comentario->id > 0) {
            $response = ['op' => 'Create', 'result' => $result, 'id' =>$comentario->id];
            return redirect('backend/comentario')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'Algo ha fallado']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function show(Comentario $comentario)
    {
        return view('backend.comentario.show', ['comentario' =>$comentario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
     
    function showComentarios ($idnoticia) 
    {
        //dd($idnoticia);
        //$comentarios = Comentario::paginate(2);
        $comentarios = Comentario::where('idnoticia', $idnoticia)
                                ->orderBy('fechacomentario', 'asc')
                                ->paginate(2);
                                //->get();
        return view('backend.comentario.index', ['comentarios' => $comentarios]);
    }
    
    public function edit(Comentario $comentario)
    {
        $noticias = Noticia::all();
        return view('backend.comentario.edit', ['comentario' => $comentario, 'noticias' => $noticias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentario $comentario)
    {
        try {
        //dd($request);
        $result = $comentario->update($request->all());
        } catch (\Exception $e) {
            $result = 0;
        }
        if($result) {
            $response = ['op' => 'actualizar', 'result' => $result, 'id' => $comentario->id];
            return redirect('backend/comentario')->with($response);
        } else {
            return back()->withInpu()->with(['error' => 'Ha ocurrido un error durante la actualización']);
           
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comentario $comentario)
    {
        $id = $comentario->id;
        try{
            $result = $comentario->delete();
        } catch(\Exception $e) {
            $result = 0; 
        }
        $response = ['op' => 'Borrado', 'result' => $result, 'id' => $id];
        return redirect('backend/comentario')->with($response);
    }
}
