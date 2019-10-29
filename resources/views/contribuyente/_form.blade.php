{!! Form::model($contribuyente, ['action' => $action, 'class' => 'form', 'method' => $method]) !!}
<div class="form__field full-width">
    {!! Form::label('razon_social', 'Nombre o Razón Social', ['class' => 'form__label']) !!}
    {!! Form::text('razon_social', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field fourth-width">
    {!! Form::label('giro_id', 'Giro', ['class' => 'form__label']) !!}
    {!! Form::input('giro_id', null, ['class' => 'form__input']) !!}
</div>

<!-- <div class="form__field">
{!! Form::label('tipo_contribuyente', 'Tipo de Contribuyente', ['class' => 'form__label']) !!}
{!! Form::select('tipo_contribuyente', [1 => 'Natural', 2 => 'Jurídico'], null, ['class' => 'form__input']) !!}
</div> -->

<div class="form__field third-width"></div>

<div class="form__field half-width">
    {!! Form::label('domicilio', 'Domicilio', ['class' => 'form__label']) !!}
    {!! Form::text('domicilio', null, ['class'=> 'form__input']) !!}
</div>

<div class="form__field">
    {!! Form::label('ciudad', 'Ciudad', ['class' => 'form__label']) !!}
    {!! Form::text('ciudad', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field full-width">
    <button class="btn">Guardar</button>
</div>
{!! Form::close() !!}

