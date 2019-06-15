@extends('layout.base')

@section('title', $title)

@section('content')
<h1 class="title">{{ $title }}</h1>
@include('giro._form')

{{-- Display errors --}}

@if ($errors->any())
<div class="error">
@foreach ($errors->all() as $error)
<span class="msg">{{ $error }}</span>
@endforeach
</div>
@endif
@endsection