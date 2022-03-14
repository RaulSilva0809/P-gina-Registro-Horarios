<?php

namespace App\Imports;

use App\Models\catalogo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CatalogoImport implements ToModel,WithHeadingRow
{
    private $numRows;

    public function model(array $row)
    {
        ++$this->numRows;
            return new catalogo([
            'codigoQR'      => $row['codigoqr'],	
            'marca'	        => $row['marca'],
            'numeroparte'   => $row['numeroparte'],
            'sku'           => $row['sku'],
            'nombre'        => $row['nombre'],
            'descripcion'   => $row['descripcion'],
            'categoria'     => $row['categoria'],
            'subcategoria'  => $row['subcategoria'],
            'imagen'        => $row['imagen'],
            'msrp'          => $row['msrp'],
            'msrplink'	    => $row['msrplink'],
            'subtotal'      => $row['subtotal'],
            'total'         => $row['total'],
           
            ]);
      
    }

    public function rules(): array
    {
        return [ 
                'codigoQR' => 'required',
                'marca'	=> 'required',
                'numeroparte' => 'required',
                'sku'    => 'required',
                'nombre' => 'required',
                'descripcion' => 'required',
                'categoria' => 'required',
                'subcategoria' => 'required',
                'imagen' => 'required',
                'msrp' => 'required',
                'msrplink'=> 'required',
                'subtotal'=> 'required',
                'total'    => 'required',         

        ];
    }

 
    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
