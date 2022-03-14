<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    { 
        $rol = role::all();
        return view('roles.roltable', ['roles' => $rol]);
    
    }
    public function create()
    {
        return view('roles.rolcreate');
    }

   
    public function store(Request $request)
    {
        $rol = new role();
        $rol->nombre = request('nombre');
        $rol->descripcion = request('descripcion');
        
        
        $rol->save();
         
        return redirect('/roles');

    }

    public function edit($id)
    {
        return view('roles.roledit', ['rol' => role::findOrFail($id)]);
    }


    public function update(Request $request, $id)
    {
        $rol = role::findOrFail($id);

        $rol->nombre =             $request->get('nombre');
        $rol->descripcion =        $request->get('descripcion');
        
        
        $rol->update();
         
        return redirect('/roles')->with('editar','ok');
        
    }


  
    public function destroy( $id)
    {
        $rol = role::findOrFail($id);

        $rol->delete();
        
        return redirect('/roles');

    }
}
