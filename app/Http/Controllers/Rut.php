<?php
    
namespace App\Http\Controllers;
use App\Contribuyente;

class Rut
{

    /**
     * Rut desde el que se comenzaran a crear el resto.
     */
    private $rutBase = 75000000;
    /**
     * Cada giro tendra un rango de ruts disponibles.
     */
    private $offset = 250000;

    public function getRutBase()
    {
        return $this->rutBase;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    private function ultimoRut($idGiro)
    {
        $ultimoRut = 0;
        $ultContribuyente = Contribuyente::where('giro_id', $idGiro)
                                ->orderBy('rut', 'desc')
                                ->first();
        if (!empty($ultContribuyente))
        {
            return $ultContribuyente->rut;
        }
        
        return $ultimoRut;
    }

    /** 
     * Funcion genera un RUT dependiendo el tipo de giro
     * y busca el ultimo RUT generado para generar el siguiente RUT
     * en base a ese RUT.
     * @param int $idGiro
     * @return int
     */
    public function generarRut(int $idGiro)
    {
        $nuevoRut = 0;
        $rutLimite = $this->getRutBase() + ($this->getOffset() * $idGiro) - 1;
        $ultimoRut = $this->ultimoRut($idGiro);
        if ($ultimoRut)
        {
            $nuevoRut = $ultimoRut + 1;
            return $nuevoRut;
        }
        $nuevoRut = $this->getRutBase() + ($this->getOffset() * ($idGiro - 1));//Primer rut generado para ese giro en especifico
        return $nuevoRut;
    }

    /**
     * Funcion  crea el digito verificador del rut dado
     * @param int $rut
     * @return string $digito
     */
    public static function digVerificador($rut)
    {
        $rut = (string)$rut;
        $factor = 2;
        $suma = 0;
        for($i = strlen($rut) - 1; $i >= 0; $i--) {
            $suma += $factor * $rut[$i];
            $factor = $factor % 7 == 0 ? 2 : $factor + 1;
        }
        $dv = 11 - $suma % 11;
        if ($dv == 11)
        {
            return 0;
        }
        if ($dv == 10)
        {
            return 'k';
        }
        return $dv;
    }
 
}
?>