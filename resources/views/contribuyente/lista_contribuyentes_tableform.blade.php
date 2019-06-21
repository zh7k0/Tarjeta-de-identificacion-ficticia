@extends('layout.base')
@section('title', $title)

@section('content')
@if (session('message'))
<div class="message popup {{ session('status') ? 'success': 'error'}}">{{ session('message') }}</div>
@endif
<table class="table">
    
    <thead>
        <th class="table__cell">Rut</th>
        <th class="table__cell">Nombre o Razón Social</th>
        <th class="table__cell">Giro</th>
        <th class="table__cel">Domicilio</th>
        <th class="table__cel"></th>
        <th class="table__cel"></th>
        <th class="table__cll"></th>
    </thead>

    @forelse ($contribuyentes as $contribuyente)
    <tr>
        <td class="table__cel">{{ number_format($contribuyente->rut, 0, ',', '.') }}-{{ $contribuyente->dig_verificador }}</td>
        <td class="table__cel">{{ $contribuyente->razon_social }}</td>
        <td class="table__cel">{{ $contribuyente->giro->nombre}}</td>
        <td class="table__cel">{{ $contribuyente->domicilio }}</td>
        <td class="table__cel"><a class="btn btn--md btn--squre" href="{{ route('mostrar_contribuyente', ['contribuyente' => $contribuyente->rut])}}">Ver Credencial</a></td>
        <td class="table__cel"><a class="btn btn--md btn--squre" href="{{ route('editar_contribuyente', ['contribuyente' => $contribuyente->rut])}}">Editar</a></td>
        <td class="table__cel">
            {!! Form::open(['method' => 'DELETE', 'action' => ['ContribuyenteController@destroy', $contribuyente->rut], 'id' => 'form-'.$contribuyente->rut]) !!}
            {!! Form::close() !!}
            {!! Form::button('X', ['class' => 'btn btn--red btn--small btn--squre', 'form' => 'form-'.$contribuyente->rut, 'type' => 'submit'])!!}
        </td>
        <td><a href="{{ action('ServicioContratadoController@index', ['contribuyente' => $contribuyente->rut])}}">Ver servicios</a></td>
    </tr>

    @empty
        <tr class="table__row"><td class="table__cell">Sin contribuyentes.</td></tr>
    @endforelse
</table>
<div>
    <a class="btn btn--squre btn--md" href="{{ route('nuevo_contribuyente')}}">Agregar</a>
</div>
@endsection