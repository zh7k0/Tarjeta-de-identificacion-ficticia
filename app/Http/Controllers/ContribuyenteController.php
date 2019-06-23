<?php

namespace App\Http\Controllers;

use App\Contribuyente;
use App\Http\Requests\ContribuyenteFormRequest;
use Facades\App\Http\Controllers\Rut;
use App\Giro;
use Barryvdh\DomPDF\Facade as PDF;

class ContribuyenteController extends Controller
{
    private $nombre = "Empresa";

    public function __construct()
    {
        $this->middleware('sanitization.input')->only('store', 'update');

    }

    public function index()
    {
        $contribuyentes = Contribuyente::with('giro')->get();
        $data['contribuyentes'] = $contribuyentes;
        $data['title'] = $this->nombre . 's';
        // $data['date'] = \date('d/m/Y');
        return view('contribuyente.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['contribuyente'] = new Contribuyente();
        $data['giros'] = $this->getGiros();
        $data['method'] = 'post';
        $data['action'] = 'ContribuyenteController@store';
        $data['title'] = 'Nueva '.$this->nombre;
        if (empty($data['giros'])){
            return redirect()->route('lista_contribuyentes')->with(['message' => 'Error: Cree al menos un giro antes de crear una nueva empresa.', 'status' => false]);
        }
        return view('contribuyente.create-edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContribuyenteFormRequest $request)
    {
        $rut = Rut::generarRut($request->giro_id);
        $dv = Rut::digVerificador($rut);
        $contribuyente = Contribuyente::create([
            'razon_social' => $request->razon_social,
            'tipo_contribuyente' => $request->has('tipo_contribuyente')? $request->tipo_contribuyente : 2,
            'dig_verificador' => $dv,
            'domicilio' => $request->domicilio,
            'giro_id' => $request->giro_id,
            'rut' => $rut
        ]);
        if(!empty($contribuyente)){
            return redirect()->route('lista_contribuyentes');
        }else {
            return view('errors.404');
        }
    }

    /**
     * Muestra el  contribuyente seleccionado.
     *
     * @param  \App\Contribuyente  $contribuyente
     * @return \Illuminate\Http\Response
     */
    public function show(Contribuyente $contribuyente)
    {
        return view('pdf_frame', array('contribuyente' => $contribuyente));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contribuyente  $contribuyente
     * @return \Illuminate\Http\Response
     */
    public function edit(Contribuyente $contribuyente)
    {
        $data['contribuyente'] = $contribuyente;
        $data['giros'] = $this->getGiros();
        $data['method'] = 'put';
        $data['action'] = ['ContribuyenteController@update', 'rut' => $contribuyente->rut];
        $data['title'] = 'Editar '. $this->nombre;
        return view('contribuyente.create-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contribuyente  $contribuyente
     * @return \Illuminate\Http\Response
     */
    public function update(ContribuyenteFormRequest $request, Contribuyente $contribuyente)
    {
        $updated = $contribuyente->update($request->only('razon_social', 'giro_id', 'domicilio'));
        if ($updated){
            return redirect()->route('lista_contribuyentes')->with(['message' => 'Actualizado correctamente', 'status' => true]);
        }
        return back()->withInput()->withErrors($e->getMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contribuyente  $contribuyente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contribuyente $contribuyente)
    {
        Contribuyente::destroy($contribuyente->rut);
        return back()->with(['message' => 'Eliminado correctamente.', 'status' => true]);
    }

    /**
     * Recupera giros de la BD y retorna un arreglo asociativo
     * @return array()
     */
    private function getGiros()
    {
        $giros = Giro::all();
        if ($giros->isEmpty()){
            return array();
        }
        $girosArray = 
        $giros->mapWithKeys(function($item){
            return [$item['id'] => $item['nombre']];
        });

        return $girosArray;
    }

    /**
     * Función renderiza en formato PDF la tarjeta de identificacion
     * del contribuyente.
     */
    public function renderPdf(Contribuyente $contribuyente)
    {
        return view('contribuyente.credencial', ['contribuyente' => $contribuyente]);
        $pdf = PDF::loadView('contribuyente.credencial', ['contribuyente' => $contribuyente]);
        $pdf->setPaper('A5', 'landscape');
        return $pdf->stream('credencial_'.$contribuyente->rut.'.pdf', array('attachment' => 0));
    }
}
