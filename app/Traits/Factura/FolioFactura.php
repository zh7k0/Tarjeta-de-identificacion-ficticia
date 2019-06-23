<?php
namespace App\Traits\Factura;
use App\Servicio;
use App\Factura;

trait FolioFactura 
{
    /**
     * @param string $servicio Servicio al cual se le desea calcular un nuevo folio
     * @return integer|null
     */
    public function getNewFolio(string $servicio)
    {
        //Verificamos que la variable esté declarada correctamente
        if (is_null($servicio) || empty($servicio)){
            return null;
        }
        //Verificamos si el servicio existe en la BD
        if ( ! Servicio::find($servicio)){
            return null;
        }

        //Obtenemos el ultimo folio creado
        $lastFolio = $this->getLastFolio($servicio);
        $nextFolio = $lastFolio + 1;
        return $nextFolio;
    }

    /**
     * Recupera el último folio creado para el servicio dado.
     * @param string $servicio
     * @return integer
     */
    protected function getLastFolio(string $servicio)
    {
        $ultimaFactura = Factura::where('servicios__tipo_servicio', $servicio)
                    ->latest('folio')
                    ->first();
        //Si no se ha creado ninguna factura aún retornamos el valor base
        if (is_null($ultimaFactura)){
            return 0;
        }

        return $ultimaFactura->folio;
    }
}
?>