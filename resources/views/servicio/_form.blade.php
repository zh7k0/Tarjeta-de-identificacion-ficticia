{!! Form::model($servicio, ['class' => 'form', 'method' => $method, 'action' => $action , 'files' => $method == 'post'? true : false]) !!}
<div class="form__field">
{!! Form::label('tipo_servicio', 'Nombre de Servicio', ['class' => 'form__label']) !!}
{!! Form::text('tipo_servicio', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field half-width">
{!! Form::label('razon_social', 'Razón Social', ['class' => 'form__label']) !!}
{!! Form::text('razon_social', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field">
{!! Form::label('rut', 'Rut', ['class' => 'form__label']) !!}
{!! Form::text('rut', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field">
{!! Form::label('giro', 'Giro', ['class' => 'form__label']) !!}
{!! Form::text('giro', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field">
{!! Form::label('domicilio', 'Dirección', ['class' => 'form__label']) !!}
{!! Form::text('domicilio', null, ['class' => 'form__input']) !!}
</div>

<div class="form__field">
{!! Form::label('comuna', 'Comuna', ['class' => 'form__label']) !!}
{!! Form::text('comuna', null, ['class' => 'form__input']) !!}
</div>

@if ($method == 'post')
<div class="form__field">
{!! Form::label('logo', 'Logo Servicio', ['class' => 'form__label']) !!}
{!! Form::file('logo', ['class' => 'form__input', 'accept' => '.png']) !!}
</div>
@endif

<div class="form__field full-width">
    <button class="btn">Agregar Servicio</button>
</div>
{!! Form::close() !!}