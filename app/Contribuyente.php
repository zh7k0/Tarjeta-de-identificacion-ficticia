<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Contribuyente extends Model
{
    // use SoftDeletes;

    protected $primaryKey = 'rut';
    public $timestamps = false;

    protected $fillable = [
        'razon_social', 'rut', 'dig_verificador', 'tipo_contribuyente', 'domicilio',
        'giro_id', 'variabilidad_cobros', 'comuna',
    ];

    public function getRouteKeyName()
    {
        return 'rut';
    }

    public function giro()
    {
        return $this->belongsTo('App\Giro');
    }

    //Recupera todos los servicios que ha contratado la empresa/cliente
    public function serviciosContratados()
    {
        return $this->hasMany('App\ServicioContratado', 'contribuyentes__rut', 'rut');
    }

    /**
     * ================ ACCESSORS ================
     */


    public function getRutCompletoAttribute()
    {
        $partesRut = array();
        $rut = (string)$this->rut;
        $partesRut[0] =  strlen($rut) <= 8 ? substr($rut, 0, 2) : substr($rut, 0, 3);
        $partesRut[1] = substr($rut, -6, 3);
        $partesRut[2] = \substr($rut, -3);
        $parsedRut = implode('.', $partesRut);
        $rutCompleto = $parsedRut . "-" . $this->dig_verificador;
        return $rutCompleto;
    }
}
