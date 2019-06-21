<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = ['tipo_servicio', 'razon_social', 
                        'rut', 'giro', 'domicilio', 'comuna', 'url_logo'];

    protected $primaryKey = 'tipo_servicio';

    //Tells that primary isn't auto incrementing
    public $incrementing = false;

    //We tell Eloquent that primary isn't integer.
    protected $keyType = 'string';

    public $timestamps = false;

    public function getRouteKeyName()
    {
        return 'tipo_servicio';
    }

    public function configFactura()
    {
        return $this->hasOne('App\ConfigFactura', 'servicios__tipo_servicio');
    }

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

}
