@extends('layout.base')

@section('title', $title)

@section('content')
<h1 class="title">{{ $title }}</h1>
@include('factura._lista_facturas')

@endsection