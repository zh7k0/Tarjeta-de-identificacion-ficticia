<?php

namespace App\Http\Controllers;

use App\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['servicios'] = Servicio::all();
        return view('servicio.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['giro'] = new Servicio();
        $data['title'] = 'Nuevo Servicio';
        $data['action'] = 'ServicioController@store';
        $data['method'] = 'post';
        return view('servicio.create-edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $servicio = Servicio::create([
            'tipo_servicio' => $request->tipo_servicio,
            'razon_social' => $request->razon_social,
            'rut' => $request->rut,
            'giro' => $request->giro,
            'domicilio' => $request->domicilio,
            'comuna' => $request->comuna,
            'url_logo' => $logo
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        $data['servicio'] = $servicio;
        $data['title'] = 'Editar Servicio';
        $data['action'] = ['ServicioController@update', 'giro' => $giro->id];
        $data['method'] = 'put';
        return view('servicio.create-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Servicio $servicio)
    {
        $updated = $servicio->update($request->all());
        if ($updated){
            return redirect()->action('ServicioController@index')->with(['message' => 'Actualizado correctamente', 'status' => true]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        //
    }
}
