<?php

namespace App\Exports;

use Illuminate\Http\Request;
use App\Models\productos;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductosExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         
        
       return productos::where("status","=","Nuevo Registro")->ORWHERE("status","=","No recolectado")
        ->get();
    }

    public function headings(): array{
        return [
            'id',
            'id_guia',
            'cdsid',
            'nombre',
            'c_unidad',
            'd_unidad',
            'reportar',
            'producto',
            'sku',
            'localidad',
            'created', 
            'modified',
            'usuario',
            'status'
        ];
    }
}
