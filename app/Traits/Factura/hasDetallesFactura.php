<?php
namespace App\Traits\Factura;

trait hasDetallesFactura {
    /**
     * ============== MUTATORS ==============
     */

    /**
     * Transforma el arreglo de detalles en string
     * @param array $values
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
      * ============== END MUTATORS ==============
     */

    /**
     * ============== ACCESSORS ==============
     */

    public function getDetallesAttribute()
    {
        return explode(';', $this->attributes['detalles']);
    }

    public function getCantidadesAttribute()
    {
        return explode(';', $this->attributes['cantidades']);
    }

    public function getPorcPorDetalleAttribute()
    {
        return explode(';', $this->attributes['porc_por_detalle']);
    }
}
?>