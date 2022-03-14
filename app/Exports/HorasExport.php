<?php

namespace App\Exports;

use App\Models\horas;
use Maatwebsite\Excel\Concerns\FromCollection;

class HorasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    
    public function collection()
    {
        return horas::select("Nombre","Apaterno","Amaterno","Hora","Fecha","Retardo","Tipo","Ubicacion","Latitud","Longitud")->orderBy('created_at','DESC')->get();

    }
    
    public function headings(): array{
        return [
                'Nombre',
                'Apaterno',
                'Amaterno',
                'Hora',
                'Fecha',
                'Retardo',
                'Tipo',
                'Ubicacion',
                'Latitud',
                'Longitud',
                ];
    }

}
