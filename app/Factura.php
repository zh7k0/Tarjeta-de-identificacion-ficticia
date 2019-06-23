<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $primaryKey = ['contribuyentes__rut', 'servicios__tipo_servicio', 'mes_emision', 'anio_emision'];

    //Tells that primary isn't auto incrementing
    public $incrementing = false;

    //We tell Eloquent that primary isn't integer.
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['folio', 'contribuyentes__rut', 'servicios__tipo_servicio', 
                            'mes_emision', 'anio_emision', 'dia_emision', 'total',
                            'neto', 'iva', 'dia_venc', 'anio_venc', 'mes_venc'
                        ];
    
    protected $casts = ['folio' => 'integer', 'neto' => 'integer', 'iva' => 'integer', 'total' => 'integer'];

    //Recupera información del servicio que emite la factura
    public function servicio()
    {
        return belongsTo('App\Servicio', 'servicios__tipo_servicio', 'tipo_servicio');
    }

    //Recupera la información del cliente que recibe la factura
    public function contribuyente()
    {
        return belongsTo('App\Contribuyente', 'contribuyentes__rut', 'rut');
    }

}
