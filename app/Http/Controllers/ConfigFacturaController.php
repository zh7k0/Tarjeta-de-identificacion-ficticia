<?php

namespace App\Http\Controllers;

use App\ConfigFactura;
use App\Servicio;
use Illuminate\Http\Request;
use App\Traits\Factura\DetallesFactura;

class ConfigFacturaController extends Controller
{
    use DetallesFactura;

    /**
     * Show the form for creating a new resource.
     * @param string $tipoServicio
     * @return \Illuminate\Http\Response
     */
    public function create($tipoServicio)
    {
        $data['title'] = 'Nuevo Servicio';
        $data['action'] = ['ConfigFacturaController@store', 'servicio' => $tipoServicio];
        $data['method'] = 'post';
        return view('config_factura.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $configFactura = new ConfigFactura();
        $configFactura->detalles = $this->getDetalles($request->except('_token'));
        $configFactura->cantidades = $this->getCantidades($request->except('_token'));
        $configFactura->porc_por_detalle = $this->getPorcentajes($request->except('_token'));
        $configFactura->servicios__tipo_servicio = $request->tipo_servicio;

        $saved = $configFactura->save();

        /**
         * Determinamos si el modelo fue guardado exitosamente en la BD,
         * de no ser así procedemos a eliminar el servicio asociado a esta
         * configuración de factura pues un servicio NO puede existir
         * sin su correspondiente configuración para el llenado de facturas.
         */
        if ($saved){
            return redirect()->action('ServicioController@index')
                            ->with(['message' => 'Guardado exitosamente.', 'status' => true]);
        }

        //Eliminamos servicio
        $servicio = Servicio::find($request->tipo_servicio);
        $servicio->delete();
        return redirect()->action('ServicioController@index')
                            ->with(['message' => 'No se pudo guardar servicio.', 'status' => false]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigFactura  $configFactura
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigFactura $configFactura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigFactura  $configFactura
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigFactura $configFactura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConfigFactura  $configFactura
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfigFactura $configFactura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigFactura  $configFactura
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfigFactura $configFactura)
    {
        //
    }
}
