<?php
namespace App\Traits\Factura;

use App\Factura;

trait VerificarExistenciaFactura 
{
    /**
     * Determina si el servicio contratado fue facturado en el mes actual.
     * @param string $rut Rut de la empresa que contrato el $servicio.
     * @param string $servicio Nombre del servicio.
     * @return boolean
     */
    protected function fueFacturado(string $rut, string $servicio)
    {
        $mesActual = date('m'); 
        $facturaEncontrada = Factura::where([
                        ['contribuyentes__rut', $rut], 
                        ['servicios__tipo_servicio', $servicio],
                        ['mes_emision', $mesActual]
                        ])->first();
        if (! $facturaEncontrada){
            return false;
        }
        return true;
    }
}
?>