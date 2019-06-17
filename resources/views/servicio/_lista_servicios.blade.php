<div class="table">
    <div class="table__row table__header">
        <div class="table__cell">Empresa</div>
        <div class="table__cell">Servicio</div>
        <div class="table__cell">Rut</div>
        <div class="table__cell">Giro</div>
        <div class="table__cell">Domicilio</div>
        <div class="table__cell">Comuna</div>
        <!-- <div class="table__cell">Logo</div> -->
        <div class="table__cell"></div>
    </div>
    @forelse ($servicios as $servicio)
    <div class="table__row">
        <div class="table__cell">{{ $servicio->razon_social }}</div>
        <div class="table__cell">{{ $servicio->tipo_servicio }}</div>
        <div class="table__cell">{{ $servicio->rut }}</div>
        <div class="table__cell">{{ $servicio->giro }}</div>
        <div class="table__cell">{{ $servicio->domicilio }}</div>
        <div class="table__cell">{{ $servicio->comuna }}</div>
        <div class="table__cell"><a class="btn btn--md btn--squre" href="{{ action('ServicioController@edit', ['servicio' => $servicio->tipo_servicio])}}">Editar</a></div>
        <div class="table__cell">
            {!! Form::open(['method' => 'DELETE', 'action' => ['ServicioController@destroy', $servicio->tipo_servicio], 'id' => 'form-'.$servicio->tipo_servicio]) !!}
            {!! Form::close() !!}
            {!! Form::button('X', ['class' => 'btn btn--red btn--small btn--squre', 'form' => 'form-'.$servicio->tipo_servicio, 'type' => 'submit'])!!}
        </div>
    </div>
    @empty
        <div class="table__row"><div class="table__cell">Sin servicios aún.</div></div>
    @endforelse
</div>
<div>
    <a class="btn btn--md" href="{{ action('ServicioController@create')}}">Agregar</a>
</div>