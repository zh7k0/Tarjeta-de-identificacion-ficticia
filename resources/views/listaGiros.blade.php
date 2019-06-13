@extends('layout.base')
@section('title', 'Giros Comerciales')

@section('content')
<div class="table">
    <div class="table__row table__header">
        <div class="table__cell">Cod. Giro</div>
        <div class="table__cell">Giro</div>
        <div class="table__cell"></div>
        <div class="table__cell"></div>
    </div>
    @forelse ($giros as $giro)
    <div class="table__row">
        <div class="table__cell">{{ $giro->id }}</div>
        <div class="table__cell">{{ $giro->nombre }}</div>
        <div class="table__cell"><a class="btn btn--md" href="{{ route('giros.edit', ['giro' => $giro->id])}}">Editar</a></div>
        <div class="table__cell">
            {!! Form::open(['method' => 'DELETE', 'action' => ['GiroController@destroy', $giro->id], 'id' => 'form-'.$giro->id]) !!}
            {!! Form::close() !!}
            {!! Form::button('X', ['class' => 'btn btn--red dlt-btn btn--small', 'form' => 'form-'.$giro->id, 'type' => 'submit']) !!}
        </div>
    </div>
    @empty
    <div class="table__row"><div class="table__cell">Sin giros aún.</div></div>
    @endforelse
</div>
<div>
    <a class="btn btn--md" href="{{ action('GiroController@create')}}">Agregar</a>
</div>
@endsection