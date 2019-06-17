@extends('layout.base')

@title('title', 'Panel de control')

@section('content')

@include('contribuyente._info')
@include('factura._listadoFacturas')
@endsection