<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;
use App\Models\sucursal;
use Faker\Provider\File;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
         //$users = User::all()->simplepaginate(10);
         $users = User::simplepaginate(20);

    
        return view('users.usuariostable', ['users' => $users]);
       // return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function create()
    {
       $roles = role::all();
       
        return view('users.usuarioscreate',['roles'=> $roles ]);
       // 
    }

   public function store( UserFormRequest $request)
     {

        $usuario  = new User();
        // $usuario->id = $request->input('id'); 
        $usuario->name = $request->input('name'); 
        $usuario->ap = $request->input('ap'); 
        $usuario->am = $request->input('am'); 
        $usuario->idEmpleado = $request->input('idEmpleado');
        $usuario->email = $request->input('email'); 
        $usuario->descripcion = $request->input('descripcion'); 

        if($request->hasFile('imagen')){
            $file = $request->imagen;
            $file->move(public_path(). '/fotoperfil', $file->getClientOriginalName());
            $usuario->imagen = $file->getClientOriginalName();
        }
    
        if($request->hasFile('imagen2')){
            $file = $request->imagen2;
            $file->move(public_path(). '/fotoqr', $file->getClientOriginalName());
            $usuario->imagen2 = $file->getClientOriginalName();
        } 
        $usuario->url = $request->input('url'); 
        $usuario->password =bcrypt($request->input('password'));
        $usuario->save();
        $usuario->asignarRol($request->get('rol'));
      
        return redirect('/usuarios');
     }

     public function show($id)
    {
        $roles = Role::all();
        
        return view('users.usuariosshow', ['user' => User::findOrFail($id),'roles' => $roles]);
    }


    public function edit($id)
    {
        $roles = Role::all();
        
        return view('users.usuariosedit', ['user' => User::findOrFail($id),'roles' => $roles]);
    }


    public function update(Request $request, $id)
    {
        $this->validate(request(), ['email' => ['required', 'email', 'max:255', 'unique:users,email,'. $id]]);
        $usuario  = User::findOrFail($id);
        $usuario->name = $request->get('name'); 
        $usuario->ap = $request->get('ap');
        $usuario->am = $request->get('am');
        $usuario->idEmpleado = $request->get('idEmpleado');
        $usuario->email = $request->get('email'); 
       $usuario->descripcion = $request->get('descripcion');
       $usuario->url = $request->get('url');

      if($request->hasFile('imagen')){
        
            $file = $request->imagen;
            $file->move(public_path(). '/fotoperfil', $file->getClientOriginalName());
            $usuario->imagen = $file->getClientOriginalName();
        }

        if($request->hasFile('imagen2')){
        
            $file = $request->imagen2;
            $file->move(public_path(). '/fotoqr', $file->getClientOriginalName());
            $usuario->imagen2 = $file->getClientOriginalName();
        }
        

        $pass = $request->get('password');
        if ($pass != null){
            $usuario->password = bcrypt($request ->get ('password'));
        }else{
            unset($usuario ->password);
        }

        $role = $usuario->roles;
        if(count($role)>0){
            $role_id = $role[0]->id;
            User::find($id)->roles()->updateExistingPivot($role_id,['role_id' => $request->get('rol')]);
        }else{
            $usuario->asignarRol($request->get('rol'));
        }

        $usuario->update();
        return redirect('/usuarios');
    }

    public function destroy( $id)
    {
        $user = User::findOrFail($id);

        $user->delete();
        
        return redirect('/usuarios');

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'telefono' => ['required', 'string', 'min:10', 'unique:users'],
        ]);
    }



}