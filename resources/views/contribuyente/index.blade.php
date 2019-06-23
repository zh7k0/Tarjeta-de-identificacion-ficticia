@extends('layout.base')
@section('title', $title)

@section('content')
@if (session('message'))
<div class="message popup {{ session('status') ? 'success': 'error'}}">{{ session('message') }}</div>
@endif

@include('contribuyente._lista_contribuyentes')

<div>
    <a class="btn btn--squre btn--md" href="{{ route('nuevo_contribuyente')}}">Agregar</a>
</div>

@endsection