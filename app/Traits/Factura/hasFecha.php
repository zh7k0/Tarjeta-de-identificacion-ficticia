<?php
namespace App\Traits\Factura;


trait hasFecha
{
    protected function getFechaVenc(array $fechaEmision)
    {
        /** 
         * Si arreglo es inválido o no existe retornamos la fecha actual
         * como arreglo asociativo.
         */ 
        if ((! \is_array($fechaEmision)) || (\array_count_values($fechaEmision) < 3)){
            return array_combine( ['d', 'm', 'y'], explode('/', date('d/m/y')));
        }
        $dia_emision = (int) $fechaEmision['d'];
        $mes_emision = (int) $fechaEmision['m'];
        $anio_emision = (int) $fechaEmision['y'];

        //Verificamos si estamos en el último mes del año
        if ($mes_emision === 12){
            $mes_venc = 1;
            $anio_venc = $anio_emision + 1;
        } else {
            $mes_venc = $mes_emision + 1;
            $anio_venc = $anio_emision;
        }

        //Verificamos el dia para el caso especial de febrero
        if ($mes_venc === 2 && $dia_emision > 28){
            $dia_venc = 28;
        /**
         * También verificamos si el día de vencimiento es mayor a 30
         * cuando el mes de vencimiento corresponde a un mes de 30 días.
         * De ser así la fecha de vencimiento se corre para el 30 de ese mes.
         */
        } elseif ($dia_emision > 30 && in_array($mes_venc, [4, 6, 9, 11])) {
            $dia_venc = $dia_emision - 1;
        } else {
            $dia_venc = $dia_emision;
        }

        $fechaVenc = [
            'd' => $dia_venc,
            'm' => $mes_venc,
            'y' => $anio_venc,
        ];
        return $fechaVenc;
    }
}
?>