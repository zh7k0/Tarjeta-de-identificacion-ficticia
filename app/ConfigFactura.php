<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfigFactura extends Model
{
    protected $table = 'config_facturas';
    protected $primaryKey = 'servicios__tipo_servicio';

    //Tells that primary isn't auto incrementing
    public $incrementing = false;

    //We tell Eloquent that primary isn't integer.
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['servicios__tipo_servicio', 'detalles', 'cantidades', 'porcen_por_detalle'];

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicios__tipo_servicio');
    }
}
