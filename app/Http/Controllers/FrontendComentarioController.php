<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Http\Request;

class FrontendComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('frontend.comentario.create');
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
            $response = ['op' => 'Su comentario se ha insertado con éxito.', 'result' => $result, 'id' =>$comentario->id];
            return redirect()->route('frontend.noticia.show', ['noticia' =>$comentario->idnoticia])->with($response);
            //return redirect('frontend/noticia')->with($response);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        //
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
        //
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
        $response = ['op' => 'Se ha borrado el comentario con éxito.', 'result' => $result, 'id' => $id];
        return redirect()->route('frontend.noticia.show', ['noticia' =>$comentario->idnoticia])->with($response);
        //return redirect('frontend/noticia')->with($response);
    }
}
