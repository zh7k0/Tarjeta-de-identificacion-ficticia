@extends('errors.minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
<h1>Error</h1>
<p>Algo inesperado ocurrió con el servidor.</p>
<p>Nuestros ingenieros chasquilas nos dicen que sucede lo siguiente:</p>
@if(isset($error))
<li>{{ $error }}</li>
@endif
@endsection
