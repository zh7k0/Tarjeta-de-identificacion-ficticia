@extends('layout.base')

@section('title', 'Panel de control')

@section('content')

<h1 class="title">Datos de la Empresa</h1>
<a class="btn btn--md btn--squre" href="{{ route('editar_contribuyente', ['contribuyente' => $contribuyente->rut])}}">Editar</a>
@include('contribuyente._info')

<h1 class="title">Credencial</h1>
<a class="btn" href="{{ action('ContribuyenteController@renderPdf', array('contribuyente' => $contribuyente)) }}" target="_blank">Ver Credencial</a>

<h1 class="title">Facturas de este mes</h1>
@include('factura._lista_facturas')

<h1 class="title">Facturas por vencer este mes</h1>
@include('factura._lista_facturas', ['facturas' => $facturasPorVencer])

@endsection