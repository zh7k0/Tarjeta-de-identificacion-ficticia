@extends('layout.base')

@section('title', 'Servicios Contratados')

@section('content')

@if (session('message'))
<div class="message popup {{ session('status') ? 'success': 'error'}}">{{ session('message') }}</div>
@endif

<h1 class="title">{{ $razonSocialContribuyente }}</h1>
@include('servicio_contratado._lista_servicios')

<div>
    <a class="btn btn--squre btn--md" href="{{ action('ServicioContratadoController@contratarServicio', $rutContribuyente)}}">Agregar</a>
</div>
@endsection