<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('administrador')->only(['create', 'store', 'destroy']);
        $this->middleware('auth');
        $this->middleware('verified');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $current_user = request()->user();
        return view('backend.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        try {
        $result = $user->save();
        } catch(\Exception $e) {
            $result = 0;
        }
        if($user->id > 0){
            $response = ['op' => 'create', 'r' => $result, 'id' => $user->id];
            return redirect('backend/usuario')->with($response);
        } else {
            return back()->withInput()->with(['error' => 'Algo ha fallado']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $current_user = request()->user();
        /*if($current_user->id != $user->id && $user->id == 1) { 
            return redirect('backend/usuario');
        }
        return view('backend.user.edit', ['user' => $user]);*/
        if($current_user->id == $user->id || $current_user->id ==1) {
            return view('backend.user.edit', ['user' => $user]);
        } else {
            return redirect('backend/usuario');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $current_user = request()->user();
        $result = 0;
        /*if($current_user->id != $user->id && $user->id == 1) { 
            return redirect('backend/usuario');
        }*/
        if(!($current_user->id == $user->id || $current_user->id ==1)) {
             return redirect('backend/usuario');
        } 
        $this->validatorEdit($request->all(), $user->id)->validate();
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != null) {
            $user->password = Hash::make($request->password);
        }
        try {
            $result = $user->save();
        } catch(\Exception $e) {
            $result = 0;
        }
        $response = ['op' => 'update', 'r' => $result, 'id' => $user->id];
        return redirect('backend/usuario')->with($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $current_user = request()->user();
        $result = 0;
        //dd([$current_user, $user]);
        if($current_user->id != $user->id && $user->id != 1) {
            try {
                $result = $user->delete();
            } catch(\Exception $e) {
                $result = 0;
            }
        }
        
        $response = ['op' => 'destroy', 'r' => $result, 'id' => $user->id];
        return redirect('backend/usuario')->with($response);
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }
    
    protected function validatorEdit(array $data, $id)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id,],
            'password' => ['nullable', 'string', 'min:8'],
        ]);
    }
}
