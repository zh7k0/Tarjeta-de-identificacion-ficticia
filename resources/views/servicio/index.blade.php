@extends('layout.base')

@section('title', 'Servicios')

@section('content')

    @if (session('message'))
    <div class="message popup {{ session('status') ? 'success': 'error'}}">{{ session('message') }}</div>
    @endif

    @include('servicio._lista_servicios')

@endsection