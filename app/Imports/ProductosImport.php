<?php

namespace App\Imports;

use App\Models\productos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ProductosImport implements ToModel,WithHeadingRow,SkipsOnError,WithValidation,SkipsOnFailure
// ,WithBatchInserts,WithChunkReading
{
    use Importable,SkipsErrors,SkipsFailures;
    
    private $numRows=0;

    public function model(array $row)
    {

            ++$this->numRows;
       
            $usuario=Auth::user()->email; 
            $status='Nuevo Registro';
    
            $sql= DB::table('productos as p')
            ->join('catalogos as c', 'p.sku', '=', 'c.sku')
            ->update([ 'p.imagen2' => DB::raw("`c`.`imagen`") ]);
            
    
            $imagen2= $sql;
            
                return new productos([
                    'idguia'  => $row['id'],
                    'cdsid' => $row['cdsid'],
                    'nombre' => $row['nombre'],
                    'cunidad'=> $row['cunidad'],
                    'dunidad'=> $row['dunidad'],
                    'reportar' => $row['reportar'],
                    'producto'=> $row['producto'],
                    'sku'=> $row['sku'],
                    'localidad'=> $row['localidad'],
                    'usuario' => $usuario,
                    'status' => $status,
                    'imagen2' => $imagen2
               
                ]);
        


        
      
    }

    public function rules(): array
    {
        return [

            //'*.idguia'  => ['idguia', 'unique:productos,id'],
            // 'idguia' => 'required',
            //'cdsid' => 'required',
            //     'nombre' => 'required',
            //     'Cunidad'=> 'required',
            //     'Dunidad'=> 'required',
            //     'producto'=> 'required',            
            //     'sku'=> 'required'       ,       
            //     'localidad'=> 'required'             

        ];
    }

 
    public function getRowCount(): int
    {
        return $this->numRows;
    }

    
    
    public function onFailure(Failure ...$failures)
    {
        
    }
    
    // public function batchSize(): int
    // {
    //     return 300;
    // }
    // public function chunkSize(): int
    // {
    //     return 1000;
    // }
}