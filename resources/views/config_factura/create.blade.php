@extends('layout.base')

@section('title', $title)

@section('content')
<h1 class="title">{{ $title }}</h1>
@include('config_factura._form')

<div class="template-row">
    <div class="table__cell"><input type="text" name="detalle" placeholder="Ingrese detalle..."></div>
    <div class="table__cell"><input type="number" name="cantidad" min="0" max="9999"></div>
    <div class="table__cell"><input type="number" name="porc_precio" min="0" max="100"></div>
</div>

@endsection