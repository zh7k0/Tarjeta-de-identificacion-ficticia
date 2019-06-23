<?php
namespace App\Traits\Factura;

trait hasDetallesFactura {
    /**
     * ===============MUTATORS==================
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
      * ==============END MUTATORS===================
      */
}
?>