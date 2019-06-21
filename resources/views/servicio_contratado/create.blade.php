@extends('layout.base')

@section('title', 'Contratacion de servicio')

@section('content')

@include('servicio_contratado._form')

<div class="template-row">
        <div class="table__cell"><input type="text" name="detalle" placeholder="Ingrese detalle..."></div>
        <div class="table__cell"><input type="number" name="cantidad" min="0" max="9999"></div>
        <div class="table__cell"><input type="number" name="porc_precio" min="0" max="100"></div>
</div>

@if ($errors->any())
<div class="error">
@foreach ($errors->all() as $error)
<span class="msg">{{ $error }}</span>
@endforeach
</div>
@endif


@endsection