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
        'giro_id'
    ];

    public function getRouteKeyName()
    {
        return 'rut';
    }

    public function giro()
    {
        return $this->belongsTo('App\Giro');
    }
}
