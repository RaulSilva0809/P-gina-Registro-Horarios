<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class horas extends Model
{
    protected $guarded = [];
    
    public function scopeBuscarpor($query, $buscar,$buscar2) {

        if (($buscar) && ($buscar2)) {
    		return $query->whereBetween('Fecha',[$buscar , $buscar2]);
    	}
    }

    public function scopeFechapor($query, $fecha,$fecha2) {

        if (($fecha) && ($fecha2)) {
    		return $query->select('Apaterno','Tipo',)
                        //->select(horas::raw('sum(Hora)'))
                        ->selectRaw('SUM(Hora) as horas')
                        ->whereIn('Tipo',['Entrada','Salida'])
                        ->whereBetween('created_at',[$fecha,$fecha2])
                        ->groupByRaw('Apaterno,Tipo');
        }
    }

    

    
}
