<?php
namespace App\Traits\Factura;

use App\Factura;
use App\Servicio;
use App\Contribuyente;
use PDF2;

trait FacturaPDF
{
    protected $serviciosBasicos = [
        'Agua',
        'agua',
        'Agua Potable',
        'Luz',
        'luz',
        'Electricidad',
        'electricidad',
        'Gas',
        'gas'
    ];

    public function generarFactura(Factura $factura)
    {
        $this->generarFacturaServBasico($factura);
    }

    protected function generarFacturaServBasico(Factura $factura)
    {
        $servicio = $factura->servicios__tipo_servicio;
        PDF2::SetTitle($servicio);
        PDF2::SetFont('helvetica', '', 12);
        PDF2::AddPage();
        $this->agregarDatosEmisor($factura->servicio);
        $this->agregarTimbre($factura);
        $this->agregarDatosReceptor($factura);
        $this->agregarNroCliente($factura->contribuyente);
        $this->agregarDetallesFacturaServicio($factura);
        PDF2::Output($servicio.'_folio_'.$factura->folio.'.pdf');
    }

    /**
     * Genera el encabezado en la esquina superior izquierda
     * con los datos del emisor y el logo correspondiente
     */
    protected function agregarDatosEmisor(Servicio $servicio)
    {
        //MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        //Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array())

        $originalFontSize = PDF2::GetFontSizePt();
        $datos = "";
        
        //Insertamos logo
        $pathLogo = public_path("storage/".$servicio->url_logo);
        PDF2::Image($pathLogo, '', '', 0, 30,'','','C');
        
        $datos = $servicio->razon_social."\n";
        PDF2::MultiCell(100, 0, $datos, 0, 'L', 0, 1, '', 41);
        $datos = $servicio->giro."\n";
        $datos .= $servicio->domicilio."\n";
        $datos .= $servicio->comuna."\n";
        PDF2::SetFontSize(10);
        PDF2::MultiCell(100, 0, $datos, 0, 'L', 0, 1);
        
        //Reestablecemos el tamaño de la fuente
        PDF2::SetFontSize($originalFontSize);
    }

    /**
     * Genera el encabezado de identificación de la factura y el emisor
     */
    protected function agregarTimbre(Factura $factura)
    {
        $datos = "";
        $datos = "R.U.T : ".$factura->servicio->rut."\n";
        $datos .= "FACTURA ELECTRONICA\n";
        $datos .= "N° ". str_pad($factura->folio, 5, '0', STR_PAD_LEFT);
        $margins = PDF2::GetMargins();
        $topMargin = $margins['top'];
        $originalLineHeight = PDF2::GetCellHeightRatio();
        //Aumentamos el espaciado entre líneas
        PDF2::SetCellHeightRatio(3);
        PDF2::SetTextColor(250, 0, 0);
        $borderSettings = array('LTRB' => array('width' => 1, 'color' => array(255, 0, 0)));
        PDF2::MultiCell(100, 40, $datos, $borderSettings , 'C', 0 , 1, 101, $topMargin, true, 0, false, true, 50, 'M');
        PDF2::SetTextColor(0, 0, 0);
        PDF2::MultiCell(100, 0, "S.S.I.I - CHILE", 0, 'C', 0, 1, 101, '');
        PDF2::SetCellHeightRatio($originalLineHeight);
        PDF2::Ln(10);
    }

    /**
     * Genera la sección correspondiente a los datos del receptor
     * dentro del cuerpo de la factura
     */
    protected function agregarDatosReceptor(Factura $factura)
    {
        $pageWidth = $lMargin = $rMargin = $realWidth = $x = 0;
        $margins = array();
        $datosCol1 = $datosCol2 = $datosCol3 = "";
        $realWidth = $this->getRealPageWidth();
        $datosCol1 = $factura->contribuyente->razon_social;
        $datosCol2 = "Fecha Emisión";
        $datosCol3 = $factura->fechaEmision;
        PDF2::SetFont('', 'B');
        PDF2::MultiCell($realWidth/2, 0, $datosCol1, 0, 'L', 0, 0);
        PDF2::MultiCell($realWidth/4, 0, $datosCol2, 0, 'L', 0, 0);
        PDF2::SetFont('', '');
        PDF2::MultiCell($realWidth/4, 0, $datosCol3, 0, 'L');
        $datosCol1 = "RUT: " . $factura->contribuyente->rutCompleto . "\n"
                    . "GIRO: " . $factura->contribuyente->giro->nombre . "\n"
                    . $factura->contribuyente->domicilio . "\n"
                    . $factura->contribuyente->ciudad;
        PDF2::MultiCell($realWidth/2, 0, $datosCol1, 0, 'L', 0, 0);
        /**
         * Obtenemos la posicion del cursor en el eje X para poder poner la siguiente
         * linea justo debajo
         * */
        $x = PDF2::GetX();
        $datosCol2 = "Grupo Tarifario\n"
                    . "Tipo Facturación";
        PDF2::MultiCell($realWidth/4, 0, $datosCol2, 0, 'L', 0, 0);
        $datosCol3 = "BT2\nNORMAL";
        PDF2::MultiCell($realWidth/4, 0,$datosCol3, 0, 'L');
        $datosCol2 = "Fecha Vencimiento";
        PDF2::SetFont('', 'B');
        PDF2::MultiCell($realWidth/4, 0, $datosCol2, 0, 'L', 0, 0, $x);
        $datosCol3 = $factura->fechaVencimiento;
        PDF2::SetFont('', '');
        PDF2::MultiCell($realWidth/4, 0, $datosCol3, 0, 'L');
        PDF2::Ln(10);
    }

    /**
     * Genera la sección con el número de identificación del cliente
     * cuando la factura corresponde a un servicio básico Ej: agua, luz, etc.
     */
    protected function agregarNroCliente(Contribuyente $cliente)
    {
        $width = $this->getRealPageWidth();
        $height = 10;
        $rut = (string) $cliente->rut;
        $nroCliente = substr($rut, 0, 2) . substr($rut, -3) . "-" . $cliente->dig_verificador;
        PDF2::SetTextColor(255, 255, 255);
        PDF2::SetFillColor(27, 49, 69);#65afff
        PDF2::SetFont('', 'B');
        $borderSettings = array('LTB' => array('width' => 0.1, 'color' => array(0, 0, 0)));
        PDF2::MultiCell($width/3, $height, "NÚMERO DE CLIENTE", $borderSettings, 'L', true, 0, '', '', true, 0, false, true, $height, 'M');
        PDF2::SetTextColor(0, 0, 0);
        PDF2::SetFont('', '');
        PDF2::MultiCell($width/3*2, $height, $nroCliente, 'TRB', 'L', 0 , 1, '', '', true, 0, false, true, $height, 'M');
        PDF2::Ln(5);
    }

    protected function agregarDetallesFacturaServicio(Factura $factura)
    {
        $freeSpace = $this->getAvailableSpace();
        $height = $freeSpace * 0.7;
        $initialPosX = PDF2::GetX();
        $initialPosY = PDF2::GetY();
        $baseHeight = $height/20;
        $width = $this->getRealPageWidth();
        $colWidth = $width/20*9;
        $spaceBetweenMainCols = ($width/20*2);
        // dump($initialPosX, $initialPosY);
        PDF2::SetFillColor(224, 224, 224);
        PDF2::MultiCell(0, $height, '', 0, '', true);
        //Headers de cada columna
        $headerL = "Su consumo de este mes:";
        $headerR = "Su consumo en $ de este mes se calcula así:";

        PDF2::SetFillColor(27, 49, 69);
        PDF2::SetTextColor(255, 255, 255);
        //MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false)
        PDF2::MultiCell($colWidth, $baseHeight, $headerL, 0, 'L', true, 0, $initialPosX, $initialPosY, true, 0, false, true, 0, 'M');
        PDF2::MultiCell($colWidth, $baseHeight, $headerR, 0, 'L', true, 1, PDF2::GetX() + $spaceBetweenMainCols, '', true, 0, false, true, 0);
        PDF2::SetTextColor(0, 0, 0);
        
        //Escritura Columna 1
        $subColWidth = $colWidth/3;
        $fechaLectActual = "05/" . str_pad($factura->mes_emision, 2, '0', STR_PAD_LEFT) . "/" . $factura->anio_emision;
        $fechaLectAnterior = $this->calcularFechaLecturaAnt(3, $factura->mes_emision, $factura->anio_emision);
        $lectAnt = $factura->total/30;
        $lectActual = $lectAnt + floor($lectAnt*0.02);
        $consumo = number_format($lectActual - $lectAnt, 2);
        PDF2::MultiCell($subColWidth, $baseHeight*2, "Lectura Actual", 0, 'L', 0, 0);
        PDF2::MultiCell($subColWidth, $baseHeight*2, $fechaLectActual, 0, 'L', 0, 0);
        PDF2::MultiCell($subColWidth, $baseHeight*2, number_format($lectActual, 2), 0, 'L', 0, 1);

        PDF2::MultiCell($subColWidth, $baseHeight*2, "Lectura Anterior", 0, 'L', 0, 0);
        PDF2::MultiCell($subColWidth, $baseHeight*2, $fechaLectAnterior, 0, 'L', 0, 0);
        PDF2::MultiCell($subColWidth, $baseHeight*2, number_format($lectAnt, 2), 0, 'L', 0, 1);

        PDF2::MultiCell($subColWidth*2, $baseHeight*4, "Consumo", 0, 'L', 0, 0);
        PDF2::MultiCell($subColWidth, $baseHeight*4, $consumo, 0, 'L', 0, 1);

        PDF2::MultiCell($subColWidth*2, $baseHeight*4, "Consumo Facturado", 0, 'L', 0, 0);
        PDF2::MultiCell($subColWidth, $baseHeight*4, $consumo, 0, 'L', 0, 1);

        //Grafico
        $pathLogo = public_path("storage/images/grafica_consumo.png");
        PDF2::SetFont('', 'B');
        PDF2::MultiCell($subColWidth*2, $baseHeight, "Su consumo en los últimos meses:", 0, 'L', 0, 1);
        PDF2::Image($pathLogo, '', '', $subColWidth*2);

        //Fin escritura Columna 1

        //Escritura Columna 2
        // foreach ($factura->servicio->configFactura->detalles as $detalle){
        //     PDF2::Multicell($subColWidth*2, $baseHeight, $detalle, 0, 'L', 0, 1);
        // }
        

    }

    /**
     * Recupera el ancho real de escritura de la página
     */
    private function getRealPageWidth()
    {
        $pageWidth = PDF2::GetPageWidth();
        $margins = PDF2::GetMargins();
        $lMargin = $margins['left'];
        $rMargin = $margins['right'];
        $realWidth = $pageWidth - ($lMargin + $rMargin);
        return $realWidth;
    }

    /**
     * Obtiene el espacio vertical que queda disponible
     * en la página actual
     */
    private function getAvailableSpace()
    {
        $posY = PDF2::GetY();
        $pageHeight = PDF2::GetPageHeight();
        $margins = PDF2::GetMargins();
        $bMargin = $margins['bottom'];
        $freeVSpace = $pageHeight - $bMargin - $posY;
        return $freeVSpace;
    }

    /**
     * Calcula la fecha en que se hizo la lectura anterior en base
     * a la lectura actual.
     * @param int $diaActual Día en que se hizo la lectura actual
     * @param int $mesActual Mes en que se hizo la lectura acual
     * @param int $anioActual Año en que se hizo la lectura actual
     * @return string $lecturaAnterior String con la fecha en formato d/m/a
     */
    private function calcularFechaLecturaAnt($diaActual, $mesActual, $anioActual)
    {
        $mesAnterior = $anio = $lecturaAnterior = 0;
        if ($mesActual == 1){
            $mesAnterior = 12;
            $anio = $anioActual - 1;
        } else {
            $mesAnterior = $mesActual - 1;
            $anio = $anioActual;
        }

        $lecturaAnterior = str_pad($diaActual, 2, '0', STR_PAD_LEFT) . "/" . str_pad($mesAnterior, 2, '0', STR_PAD_LEFT) . "/" . $anio;
        return $lecturaAnterior;
    }
}
?>