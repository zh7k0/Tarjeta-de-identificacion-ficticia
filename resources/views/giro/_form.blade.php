{!! Form::model($giro, ['class' => 'form', 'action' => $action, 'method' => $method]) !!}
<div class="form__field half-width">
{!! Form::label('nombre', 'Descripción Giro', ['class' => 'form__label']) !!}
{!! Form::text('nombre', null, ['class' => 'form__input']) !!}
</div>
<div class="form__field">
    <button class="btn">Agregar</button>
</div>
{!! Form::close() !!}
