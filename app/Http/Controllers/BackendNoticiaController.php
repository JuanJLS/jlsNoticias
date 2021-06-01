<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoticiaCreateRequest;
use App\Http\Requests\NoticiaEditRequest;
use App\Mail\ChangeUserEmail;
use App\Models\Noticia;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mail;
use App\Models\User;

class BackendNoticiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('restoreEmail');
        $this->middleware('verified')->except('restoreEmail');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $order = ['titulo', 'autor', 'fechanoticia'];
        $noticias = new Noticia();
        $search = $request->input('search');
        if($search != null) {
            $noticias = $noticias->where('titulo', 'like', '%' . $search . '%')
                                 ->orWhere('autor', 'like', '%' . $search . '%')
                                 ->orWhere('fechanoticia', 'like', '%' . $search . '%')
                                 ->orWhere('textonoticia', 'like', '%' . $search . '%');
        }
        $orderby = $request->input('orderby');
        $sort = 'asc';
        if($orderby != null) {
            if(isset($order[$orderby])) {
                $orderby = $order[$orderby];
            } else {
                $oderby = $order[0];
            }
            if($request->input('sort') != null) {
                $sort = $request->input('sort');
            }
            $noticias = $noticias->orderBy($orderby, $sort);
        }
        $paginationParameters = ['search' => $search, 'orderby' => $orderby, 'sort' => $sort];
        $noticias = $noticias->orderBy('fechanoticia', 'asc')->paginate(2)->appends($paginationParameters);
        return view('backend.noticia.index', array_merge(['noticias' => $noticias], $paginationParameters));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.noticia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoticiaCreateRequest $request)
    {
        $all = $request->validated();
        $noticia = new Noticia($all);
        try{
            if($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $archivo = $request->file('imagen');
                $path = $archivo->getRealPath();
                $imagen = file_get_contents($path);
                $noticia->imagen = base64_encode($imagen);
            }
            $result = $noticia->save();
        } catch (\Exception $e) {
            $result = 0;
        }
        if($noticia->id > 0) {
            $response = ['op' => 'Creacion', 'resultado' => $result, 'id' => $noticia->id];
            return redirect('backend/noticia')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'Algo ha fallado.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BackendNoticiasController  $backendNoticiasController
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia)
    {
        
        return view('backend.noticia.show', ['noticia' => $noticia]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BackendNoticiasController  $backendNoticiasController
     * @return \Illuminate\Http\Response
     */
    public function edit(Noticia $noticia)
    {
        return view('backend.noticia.edit', ['noticia' => $noticia]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BackendNoticiasController  $backendNoticiasController
     * @return \Illuminate\Http\Response
     */
    public function update(NoticiaEditRequest $request, Noticia $noticia)
    {
        try{
            if($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
                $file = $request->file('imagen');
                $path = $file->getRealPath();
                $imagen = file_get_contents($path);
                $base64 = base64_encode($imagen);
                $noticia->imagen = $base64;
            }
            $result = $noticia->update($request->validated());
            $noticia->save();
        } catch(\Exception $e) {
            $e = 0;
        } 
        if($result) {
            $response = ['op' => 'actualizar', 'result' => $result, 'id' => $noticia->id];
            return redirect('backend/noticia')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'Algo ha fallado']);
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BackendNoticiasController  $backendNoticiasController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    {
        $id = $noticia->id;
        try{
            $result = $noticia->delete();
        } catch(\Exception $e) {
            $result = 0;
        }
        $response = ['op' => 'Borrado', 'result' => $result, 'id' => $id];
        return redirect('backend/noticia')->with($response);
    }
    
    function changePassword(Request $request) {
        $this->passwordValidate($request->all())->validate();
        //1º verificar que la clave anterior es correcta
        //2º encriptar la clave nueva y asignarla
        $user = auth()->user();
        //$user = Auth::user(); //Esta es otra forma de obtener el usuario
        if(Hash::check($request->oldpassword, $user->password)) {
            $user->password = Hash::make($request->clave);
            $user->save();
            return redirect('home')->with(['password' => true]);
        } else {
            return redirect('home')->with(['passworderror' => false])->withErrors(['passworderror' => 'No se ha podido cambiar la clave debido a que la clave anterior no es correcta.']);
        }
    }
    
    private function passwordValidate(array $data)
    {
        return Validator::make($data, [
            'oldpassword' => ['required', 'string'],
            'clave' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    
    function changeUser(Request $request)
    {
        $redirect = 'home';
        $this->userValidate($request->all())->validate();
        $user = auth()->user();
        $user->name = $request->name;
        if($user->email != $request->email) {
            $this->sendMailChanged($user);
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            session()->flash('login', true);
            Auth::logout();
            $redirect = 'login';
        }
        try {
            $user->save();
        } catch(\Exception $e){
            return back()->withInput()->withErrors(['usererror' => '...']);
        }
        return redirect($redirect)->with(['user' => true]);
    }
    
    private function sendMailChanged($user)
    {
        $ruta = \URL::temporarySignedRoute('email.restore', now()->addDays(1), ['id' => $user->id, 'email' => $user->email]);
        $correo = new ChangeUserEmail($ruta);
        Mail::to($user)->send($correo);
    }
    
    private function userValidate(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'  . auth()->user()->id],
        ]);
    }
    
    function restoreEmail(Request $request, $id, $email)
    {
        $user = User::find($id);
        $ruta = \URL::temporarySignedRoute('email.restore', now()->addDays(1), ['id' => $user->id, 'email' => $email]);
        return view('auth.restore')->with(['email' =>$email, 'nombre' => $user->name, 'ruta' => $ruta]);   
    }
    
    function restorePreviousEmail(Request $request, $id, $email)
    {
        //dd([$id, $email, $request]);
        $user = User::find($id);
        $user->email = $email;
        try {
            $user->save();
            session()->flash('restoreemail', true);
        } catch(\Exception $e) {
            session()->flash('restoreemail', false);
        }
        return redirect('login');
    }
}
