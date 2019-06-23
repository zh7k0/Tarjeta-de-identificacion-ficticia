<?php

namespace App\Http\Controllers;

use App\ServicioContratado;
use App\Contribuyente;
use App\Servicio;
use App\Http\Requests\ServContratadoFormRequest;
use App\Traits\Factura\DetallesFactura;

class ServicioContratadoController extends Controller
{
    use DetallesFactura;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Contribuyente $contribuyente)
    {
        $data['servicios'] = ServicioContratado::where('contribuyentes__rut', $contribuyente->rut)
                            ->get();
        $data['rutContribuyente'] = $contribuyente->rut;
        $data['razonSocialContribuyente'] = $contribuyente->razon_social;
        return view('servicio_contratado.index', $data);
    }

    /**
     * Muestra el formulario para contratar un servicio
     *
     * @return \Illuminate\Http\Response
     */
    public function contratarServicio(Contribuyente $contribuyente)
    {
        $data['contribuyente'] = $contribuyente;
        $data['servicioContratado'] = new ServicioContratado();
        $data['method'] = 'post';
        $data['action'] = ['ServicioContratadoController@store', 'rut' => $contribuyente->rut];
        $data['servicios'] = Servicio::all()->mapWithKeys(function ($item){
                            return [$item['tipo_servicio'] => $item['tipo_servicio']];
        });
        // dd($data);
        return view('servicio_contratado.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServContratadoFormRequest $request, $rut)
    {
        $servContratado = ServicioContratado::where([['contribuyentes__rut', $rut], ['servicios__tipo_servicio', $request->tipo_servicio]])->first();
        if ($servContratado == null){
            $servContratado = new ServicioContratado();
        }
        //Asignamos manualmente cada columna
        $servContratado->detalles = $this->getDetalles($request->all());
        $servContratado->cantidades = $this->getCantidades($request->all());
        $servContratado->porc_por_detalle = $this->getPorcentajes($request->all());
        $servContratado->servicios__tipo_servicio = $request->tipo_servicio;
        $servContratado->contribuyentes__rut = $rut;
        $servContratado->tarifa = $request->tarifa;
        //Finalmente guardamos el modelo en la BD
        $saved = $servContratado->save();
        if (! $saved){
            return back()->withInput()->withErrors('No se pudo guardar el servicio.');
        }
        return redirect()->action('ServicioContratadoController@index', ['contribuyente' => $rut])
                    ->with(['message' => 'Ingresado correctamente.', 'status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServicioContratado  $servicioContratado
     * @return \Illuminate\Http\Response
     */
    public function show(ServicioContratado $servicioContratado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServicioContratado  $servicioContratado
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicioContratado $servicioContratado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServicioContratado  $servicioContratado
     * @return \Illuminate\Http\Response
     */
    public function update(ServContratadoFormRequest $request, ServicioContratado $servicioContratado)
    {
        $updated = $servicioContratado->update();
        dd($updated, $servicioContratado);
        if (! $updated){
            return back()->withInput()->withErrors(['message' => 'No se actualizó.', 'status' => false]);
        }
        return redirect()->action('ServicioContratadoController@index', ['contribuyente' => $servicioContratado->contribuyentes__rut]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServicioContratado  $servicioContratado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contribuyente $contribuyente, Servicio $servicio)
    {
        $status = ServicioContratado::where([['contribuyentes__rut', $contribuyente->rut], ['servicios__tipo_servicio', $servicio->tipo_servicio]])->delete();

        return redirect()->action('ServicioContratadoController@index', ['contribuyente' => $contribuyente->rut]);
    }

}
