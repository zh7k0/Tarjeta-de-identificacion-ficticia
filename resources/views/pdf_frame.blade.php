@extends('layout.base')
@section('title', 'Tarjeta Contribuyente')
@section('content')
    <iframe style="width:100%;height:60%;" src="{{ action('ContribuyenteController@renderPdf', array('contribuyente' => $contribuyente))}}" frameborder="0"></iframe>
@endsection