<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioContratado extends Model
{
    protected $table = 'servicios_contratados';
    protected $primaryKey = ['contribuyentes__rut', 'servicios__tipo_servicio'];

    //Tells that primary key isn't auto incrementing
    public $incrementing = false;

    //Tells Eloquent to not create columns 'updated_at' and 'created_at' in Database.
    public $timestamps = false;

    protected $fillable = ['contribuyentes__rut', 'servicios__tipo_servicio', 'detalles',
                            'cantidades', 'porc_por_detalle', 'tarifa'
                        ];

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicios__tipo_servicio', 'tipo_servicio');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Contribuyente', 'contribuyentes__rut', 'rut');
    }
    
}
