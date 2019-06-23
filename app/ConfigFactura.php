<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Factura\hasDetallesFactura;

class ConfigFactura extends Model
{
    use hasDetallesFactura;


    protected $table = 'config_facturas';
    protected $primaryKey = 'servicios__tipo_servicio';

    //Tells that primary isn't auto incrementing
    public $incrementing = false;

    //We tell Eloquent that primary isn't integer.
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = ['servicios__tipo_servicio', 'detalles', 'cantidades', 'porc_por_detalle'];

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicios__tipo_servicio');
    }
}
