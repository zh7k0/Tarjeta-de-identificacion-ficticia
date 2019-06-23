<div class="table">
    
    <div class='table__row table__header'>
        <div class="table__cell">Rut</div>
        <div class="table__cell">Nombre o Razón Social</div>
        <div class="table__cell">Giro</div>
        <div class="table__cell">Domicilio</div>
        <div class="table__cell"></div>
        <div class="table__cell"></div>
        <div class="table__cell"></div>
        <div class="table__cell"></div>
    </div>

    @forelse ($contribuyentes as $contribuyente)
    
    <div class="table__row">
        <div class="table__cell">{{ number_format($contribuyente->rut, 0, ',', '.') }}-{{ $contribuyente->dig_verificador }}</div>
        <div class="table__cell">{{ $contribuyente->razon_social }}</div>
        <div class="table__cell">{{ $contribuyente->giro->nombre}}</div>
        <div class="table__cell">{{ $contribuyente->domicilio }}</div>
        <div class="table__cell"><a class="btn btn--md btn--squre" href="{{ route('mostrar_contribuyente', ['contribuyente' => $contribuyente->rut])}}">Ver Credencial</a></div>
        <div class="table__cell"><a class="btn btn--md btn--squre" href="{{ route('editar_contribuyente', ['contribuyente' => $contribuyente->rut])}}">Editar</a></div>
        <div class="table__cell"><a class="btn btn--md" href="{{ action('ServicioContratadoController@index', ['contribuyente' => $contribuyente->rut]) }}">Ver Servicios</a></div>
        <div class="table__cell">
            {!! Form::open(['method' => 'DELETE', 'action' => ['ContribuyenteController@destroy', $contribuyente->rut], 'id' => 'form-'.$contribuyente->rut]) !!}
            {!! Form::close() !!}
            {!! Form::button('X', ['class' => 'btn btn--red btn--small btn--squre', 'form' => 'form-'.$contribuyente->rut, 'type' => 'submit'])!!}
        </div>
    </div>

    @empty
        <div class="table__row"><div class="table__cell">Sin contribuyentes.</div></div>
    @endforelse
</div>
