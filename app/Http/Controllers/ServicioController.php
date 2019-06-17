<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Http\Requests\ServicioFormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Traits\LogoUpload;

class ServicioController extends Controller
{
    use LogoUpload;

    public function __construct()
    {
        $this->middleware('sanitization.input')->only(['store', 'update']);

    }

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
        $data['servicio'] = new Servicio();
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
    public function store(ServicioFormRequest $request)
    {
        /**
         * Tratamos de subir el logo primero, sino se puede subir
         * regresamos a la anterior ubicación para que intenten
         * con una imagen válida.
         */
        $logo = $request->file('logo');
        $urlLogo = $this->uploadLogo($logo, $request->tipo_servicio);

        if ( ! $urlLogo){
            return back()->with(['message' => 'No se pudo subir el logo',
                                'status' => false,
                                ])->withInput();
        }

        $servicio = Servicio::create([
            'tipo_servicio' => $request->tipo_servicio,
            'razon_social' => $request->razon_social,
            'rut' => $request->rut,
            'giro' => $request->giro,
            'domicilio' => $request->domicilio,
            'comuna' => $request->comuna,
            'url_logo' => $urlLogo
        ]);

        if ( ! empty($servicio)){
            return redirect()->action('ServicioController@index');
        } else {
            return back()->withInput()->with(['message' => 'No se pudo guardar servicio.',
                                            'status' => false,
                                            ]);
        }
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
        $data['action'] = ['ServicioController@update', 'servicio' => $servicio->tipo_servicio];
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
    public function update(ServicioFormRequest $request, Servicio $servicio)
    {
        /**
         * Verificamos si dentro de los campos por actualizar se actualizo
         * el nombre del servicio, de ser así intentamos primero actualizar
         * el nombre del logo almacenado.
         * Si no es posible renombrarlo regresamos al form con el error
         * correspondiente.
         */
        if ($request->has('tipo_servicio') && $request->tipo_servicio != $servicio->tipo_servicio){
            $newName = $request->tipo_servicio;
            $filePath = $servicio->url_logo;
            $renamed = $this->renameLogo($newName, $filePath);

            if ( ! $renamed){
                $msg = 'Error: No se pudo actualizar el servicio. Razon: El logo no se pudo actualizar.';
                return back()->withInput()->withErrors($msg);
            }
        }

        $updated = $servicio->update($request->except('logo'));
        if ($updated){
            /**
             * Si se pudieron actualizar los datos en la BD,
             * procedemos a actualizar el destino del logo
             * con el nuevo nombre cuando sea el caso
             */
            if (isset($renamed)){
                $servicio->update(['url_logo' => $renamed]);
            }
             
            return redirect()->action('ServicioController@index')->with(['message' => 'Actualizado correctamente', 'status' => true]);
        }
        return back()->withInput()->withErrors('No se pudo actualizar servicio');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        //Removemos primero el logo
        $logoRemoved = $this->deleteLogo($servicio->url_logo);
        // dd($logoRemoved);
        if ( ! $logoRemoved){
            return back()->with(['message' => 'Error: No se pudo eliminar servicio.', 'status' => false]);
        }

        $deleted = $servicio->delete();
        if ($deleted){
            return back()->with(['message' => 'Eliminado servicio correctamente', 'status' => true]);
        }
        return back()->with(['message' => 'No se pudo eliminar servicio.', 'status' => false]);
    }
}
