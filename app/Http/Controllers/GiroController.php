<?php

namespace App\Http\Controllers;

use App\Giro;
use App\Http\Requests\GiroFormRequest;

class GiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $giros = Giro::all();
        return view('giro.listaGiros', ['giros' => $giros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['giro'] = new Giro();
        $data['title'] = 'Nuevo Giro';
        $data['action'] = 'GiroController@store';
        $data['method'] = 'post';
        return view('giro.create-edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GiroFormRequest $request)
    {
        $giro = Giro::create([
            'nombre' => $request->nombre
        ]);
        if( !empty($giro)){
            return redirect()->action('GiroController@index');
        }
        else{
            return back()->withErrors();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Giro  $giro
     * @return \Illuminate\Http\Response
     */
    public function show(Giro $giro)
    {
        return redirect()->route('giros.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Giro  $giro
     * @return \Illuminate\Http\Response
     */
    public function edit(Giro $giro)
    {
        $data['giro'] = $giro;
        $data['title'] = 'Editar Giro';
        $data['action'] = ['GiroController@update', 'giro' => $giro->id];
        $data['method'] = 'put';
        return view('giro.create-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Giro  $giro
     * @return \Illuminate\Http\Response
     */
    public function update(GiroFormRequest $request, Giro $giro)
    {
        $updated = $giro->update($request->only('nombre'));
        if ($updated){
            return redirect()->route('giros.index')->with(['message' => 'Actualizado giro correctamente', 'status' => true]);
        }
        return back()->withInput()->withErrors($e->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Giro  $giro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Giro $giro)
    {
        Giro::destroy($giro->id);
        return back()->with(['message' => 'Eliminado correctamente', 'status' => true]);
    }
}
