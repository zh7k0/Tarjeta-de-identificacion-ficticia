<?php

namespace App\Http\Controllers;

use App\Factura;
use App\Contribuyente;
use App\Servicio;
use App\ServicioContratado;
use Illuminate\Http\Request;
use App\Traits\Factura\FolioFactura;
use App\Traits\Factura\hasFecha;
use App\Traits\Factura\VerificarExistenciaFactura;
use App\Traits\Factura\FacturaPDF;

class FacturaController extends Controller
{
    use FolioFactura, hasFecha, VerificarExistenciaFactura, FacturaPDF;

    /**
     * Muestra la lista de todas las facturas si $rut no es especificado,
     * en caso contrario muestra solo las facturas del $rut indicado
     * @param string $rut = null
     * @return \Illuminate\Http\Response
     */
    public function index(string $rut = null)
    {
        if (is_null($rut)){
            $data['title'] = 'Facturas';
            $data['facturas'] = Factura::all()
                            ->sortBydesc('anio_emision')
                            ->sortBydesc('mes_emision')
                            ->sortBydesc('dia_emision');
            return view('factura.index', $data);
        }
        //Recuperamos las facturas asociadas al rut
        $facturas = Factura::where('contribuyentes__rut', $rut)->get();
        $contribuyente = Contribuyente::where('rut', $rut)->first();
        $data['title'] = 'Facturas ' . $contribuyente->razon_social;
        $data['facturas'] = $facturas;
        return view('factura.index', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Contribuyente $contribuyente, Servicio $servicio)
    {
        if ( ($contribuyente->doesntExist()) || ($servicio->doesntExist())){
            return back()->with(['message' => 'Contribuyente o servicio no existe', 'status' => false]);
        }

        //Recuperamos la información del servicio para la facturación si está contratado.
        $servContratado = ServicioContratado::where([
            ['contribuyentes__rut', $contribuyente->rut],
            ['servicios__tipo_servicio', $servicio->tipo_servicio],
            ])->first();
        if (! $servContratado){
            return back()->with(['message' => 'No se pudo facturar. Servicio no ha sido contratado por empresa.',
                                'status' => false,
                                ]);
        }
        /**
         * Por último, verificamos que no se haya facturado ya el servicio
         * este mes.
         */
        if ($this->fueFacturado($contribuyente->rut, $servicio->tipo_servicio)){
            return back()->with(['message' => 'No se pudo facturar. Ya fue facturado este mes.',
                                'status' => false,
                                ]);
        }
        //Procesamiento de datos y llenado de modelo
        $fechaEmision = array_combine( ['d', 'm', 'y'], explode('/', date('d/m/Y')));
        $fechaVenc = $this->getFechaVenc($fechaEmision);
        $rango_valores = $contribuyente->variabilidad_cobros;
        $tarifa = $servContratado->tarifa;
        $minRand = $tarifa - ($tarifa * $rango_valores);
        $maxRand = $tarifa + ($tarifa * $rango_valores);
        $total = mt_rand($minRand, $maxRand);
        $neto = round($total / 1.19);
        $iva = $total - $neto;

        //Creamos la factura en la BD.
        $created = Factura::create([
            'folio' => $this->getNewFolio($servicio->tipo_servicio), 
            'contribuyentes__rut' => $contribuyente->rut, 
            'servicios__tipo_servicio' => $servicio->tipo_servicio, 
            'dia_emision' => $fechaEmision['d'], 
            'mes_emision' => $fechaEmision['m'], 
            'anio_emision' => $fechaEmision['y'], 
            'total' => $total,
            'neto' => $neto, 
            'iva' => $iva, 
            'dia_venc' => $fechaVenc['d'], 
            'anio_venc' => $fechaVenc['y'], 
            'mes_venc' => $fechaVenc['m'],
        ]);
        if (! $created){
            return back()->with(['message' => 'No se pudo crear factura.', 'status' => false]);
        }
        return back()->with(['message' => 'Facturado exitosamente', 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show($servicio, $folio)
    {
        $factura = Factura::where([
            ['servicios__tipo_servicio', $servicio],
            ['folio', $folio]
            ])->first();
        if (is_null($factura)){
            return view('errors.404');
        }
        return $this->generarFactura($factura);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Factura $factura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        //
    }
}
