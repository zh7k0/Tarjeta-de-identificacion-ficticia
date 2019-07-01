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


    /**
     * ==================== Relationships ====================
     */
    //Recupera información del servicio que emite la factura
    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicios__tipo_servicio', 'tipo_servicio');
    }

    //Recupera la información del cliente que recibe la factura
    public function contribuyente()
    {
        return $this->belongsTo('App\Contribuyente', 'contribuyentes__rut', 'rut');
    }

    /**
     * ==================== Accessors ====================
     */
    
     public function getFechaEmisionAttribute()
     {
        return $this->parsearFecha($this->dia_emision, $this->mes_emision, $this->anio_emision);
     }

     public function getFechaVencimientoAttribute()
     {
        return $this->parsearFecha($this->dia_venc, $this->mes_venc, $this->anio_venc);
     }
     /**
      * ==================== Mutators ====================
      */

    private function parsearFecha($dia, $mes, $anio)
    {
        $d = \str_pad($dia, 2, '0', STR_PAD_LEFT);
        $m = \str_pad($mes, 2, '0', STR_PAD_LEFT);
        return "{$d}/{$m}/{$anio}";
    }      
}
