<div class="table">
        <div class="table__row table__header">
            <div class="table__cell">Servicio</div>
            <div class="table__cell">Tarifa</div>
            <div class="table__cell"></div>
        </div>

        @forelse ($servicios as $servicio)
        <div class="table__row">
            <div class="table__cell">{{ $servicio->servicios__tipo_servicio }}</div>
            <div class="table__cell">{{ $servicio->tarifa }}</div>
            <div class="table__cell">
            {!! Form::open(['method' => 'DELETE', 'action' => ['ServicioContratadoController@destroy', 'contribuyente' => $servicio->cliente->rut, 'tipo_servicio' => $servicio->servicios__tipo_servicio], 'id' => 'form-'.$servicio->cliente->rut]) !!}
            {!! Form::close() !!}
            {!! Form::button('X', ['class' => 'btn btn--red btn--small btn--squre', 'form' => 'form-'.$servicio->cliente->rut, 'type' => 'submit'])!!}
            </div>
        </div>
        @empty
        <div class="table__row">
            <div class="table__cell">Sin servicios.</div>
        </div>
        @endforelse

</div>