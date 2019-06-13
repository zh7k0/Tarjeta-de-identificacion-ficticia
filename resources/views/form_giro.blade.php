@extends('layout.base')

@section('title', $title)

@section('content')
<h1 class="title">{{ $title }}</h1>
{!! Form::model($giro, ['class' => 'form', 'action' => $action, 'method' => $method]) !!}
<div class="form__field full-width">
{!! Form::label('nombre', 'Descripción Giro', ['class' => 'form__label']) !!}
{!! Form::text('nombre', null, ['class' => 'form__input']) !!}
</div>
<div class="form__field">
    <button class="btn">Agregar</button>
</div>
{!! Form::close() !!}

@if ($errors->any())
<div class="error">
@foreach ($errors->all() as $error)
<span class="msg">{{ $error }}</span>
@endforeach
</div>
@endif
@endsection