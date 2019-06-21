<?php
namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait ConfigFactura 
{

    /**
     * Devuelve un array con los elementos del arreglo asociativo $haystack
     * que contienen en su key el string dado en $needle
     * @param array $haystack
     * @param string $needle
     * @return array
     */

    private function _getFieldsThatContains(array $haystack, string $needle)
    {
        $result = array();
        if ( (! isset($haystack) ) || (! isset($needle) ) || ( empty($needle) ) ){
            return null;
        }

        foreach ($haystack as $key => $value) {
            if (Str::is($needle, $key)){
                $result += [$key => $value];
            }
        }
        return $result;
    }

    /**
     * Obtiene los campos de un arreglo asociativo que contienen 'detalle' 
     * en el inicio de su nombre como key
     */
    public function getDetalles(array $fields)
    {
        return $this->_getFieldsThatContains($fields, 'detalle*');
    }

    /**
     * Obtiene los campos de un arreglo asociativo que contienen 'cantidades' 
     * en el inicio de su nombre como key
     */
    public function getCantidades(array $fields)
    {
        return $this->_getFieldsThatContains($fields, 'cantidad*');
    }

    /**
     * Obtiene los campos de un arreglo asociativo que contienen 'porc_precio' 
     * en el inicio de su nombre como key
     */
    public function getPorcentajes($fields)
    {
        return $this->_getFieldsThatContains($fields, 'porc_precio*');
    }
}

?>