<?php

namespace App\Exports;

use App\Models\productos;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class AlmacenExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        return productos::where("status","=","Almacen")
        ->ORWHERE("status","=","Retorno")
        ->ORWHERE("status","=","No entregado")
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
