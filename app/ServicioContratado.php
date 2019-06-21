<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    
    /**
     * ===============MUTATORS==================
     */

    /**
     * @param array $value
     * 
     */
    public function setDetallesAttribute($values)
    {
        if (is_null($values)){
            $this->attributes['detalles'] = null;
            return;
        }

        if (is_array($values)){
            $this->attributes['detalles'] = implode(';', $values);
            return;
        }
    }

    public function setCantidadesAttribute($values)
    {
        if (is_null($values)){
            $this->attributes['cantidades'] = null;
            return;
        }

        if (is_array($values)){
            $this->attributes['cantidades'] = implode(';', $values);
            return;
        }
    }

    public function setPorcPorDetalleAttribute($values)
    {
        if (is_null($values)){
            $this->attributes['porc_por_detalle'] = null;
            return;
        }

        if (is_array($values)){
            $this->attributes['porc_por_detalle'] = implode(';', $values);
            return;
        }
    }
     /**
      * ==============END MUTATORS===================
      */
    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicios__tipo_servicio', 'tipo_servicio');
    }

    public function cliente()
    {
        return $this->belongsTo('App\Contribuyente', 'contribuyentes__rut', 'rut');
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('contribuyentes__rut', '=', $this->getAttribute('contribuyentes__rut'))
            ->where('servicios__tipo_servicio', '=', $this->getAttribute('servicios__tipo_servicio'));
        return $query;
    }

    
}
