<?php

namespace App\Http\Controllers;

use App\Exports\HorasExport;
use App\Models\horas;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;



class HorasController extends Controller
{

    public function index(Request $request)
    {
        
        $buscar = $request->get('buscar');
        $buscar2 = $request->get('buscar2');
          
         $horas = horas::buscarpor($buscar,$buscar2)->simplepaginate(1500);

    
        return view('horas.tablahoras', ['horas' => $horas]);
       // return view('users.index', ['users' => $model->paginate(15)]);
    }

    public function index2(Request $request)
    {
         //$users = User::all()->simplepaginate(10);
         $horas = horas::simplepaginate(20);

    
        return view('dashboard', ['horas' => $horas]);
       // return view('users.index', ['users' => $model->paginate(15)]);
    }



    public function store(Request $request)
    {
        $registroentrada  = new horas();
        $registroentrada->Nombre = $request->input('name'); 
        $registroentrada->Apaterno = $request->input('ap'); 
        $registroentrada->Amaterno = $request->input('am'); 
        $registroentrada->idEmpleado = $request->input('idEmpleado'); 
        $registroentrada->Hora = $request->input('hora');
        $registroentrada->Retardo = $request->input('valor1'); 
        $registroentrada->Tipo = $request->input('valor2');
        $registroentrada->Fecha = $request->input('dia'); 
        $registroentrada->Ubicacion = $request->input('ubicacion'); 
        $registroentrada->Longitud = $request->input('valor3');
        $registroentrada->Latitud = $request->input('valor4');

        $registroentrada->save();
        return redirect('/home');
    }
    

    //Hora de entrada

    public function entrada()
    {
        return view('horas.horasentrada');
    }

    //Hora de entrada

    public function iniciocomida()
    {
        return view('horas.iniciocomida');
    }
    //Hora de entrada

    public function finalcomida()
    {
        return view('horas.fincomida');
    }
    //Hora de entrada

    public function salida()
    {
        return view('horas.horassalida');
    }

    
    public function homeoffice()
    {
        return view('horas.homeoffice');
    }

    public function conteohoras(Request $request)
    {
        //$startDate = '2022-02-14';
        //$endDate = '2022-02-18';
        $fecha = $request->get('fecha');
        $fecha2 = $request->get('fecha2');

        $horas = horas::fechapor($fecha,$fecha2)->simplepaginate(1500);


        //$horas = horas::select("Nombre","Tipo")->SUM("Hora")->whereIn('Tipo','=', 'Entrada','Salida')
        //  ->whereBetween('Fecha' , '=', $buscar,$buscar2)->groupBy('Tipo');
        
        return view('horas.conteohoras', ['horas' => $horas]);
         //return view('horas.conteohoras');
    }

    

    public function tusregistros(Request $request)
    {

        $hola= Auth::user()->idEmpleado;

        $horas= horas::where("idEmpleado","=",$hola)->orderBy('created_at','DESC')
             ->simplePaginate(20);

         //$horas = horas::buscarpor($buscar,$buscar2)->simplepaginate(20);

        return view('horas.tusregistros', ['horas' => $horas]);
        
    }


    /* PDF*/

   public function PDF()
   {
    $data = [
        'title' => 'Informe de horas',
        'text' =>'Se hace presente de esta carta para informar de los productos entregados',
        'text1' =>'que se describen en la siguiente lista.' 
    ];
      
  
    $mesactual = date("m");

    //$horas= horas::where('created_at','Octubre')->get();
    
    $horas= horas::get();

    $pdf = PDF::loadView('horas.prueba', $data,['horas'=>$horas] )
    ->setPaper('a4');
    
    return $pdf->download('informe_horas.pdf');
   }

    //EXCEL

    public function EXCEL(Request $request)
   {
   return Excel::download(new HorasExport, 'registro-horas.xlsx');
   }


  



}

