{!! Form::model($servicioContratado, ['class' => 'form', 'method' => $method , 'action' => $action, 'id' => 'servicioData']) !!}
    <div class="form__field">
        {!! Form::label('tipo_servicio', 'Servicio a contratar', ['class' => 'form__label']) !!}
        {!! Form::select('tipo_servicio', $servicios, null, ['class' => 'form__input'])!!}
    </div>
    <div class="form__field">
        {!! Form::label('tarifa', 'Tarifa a cobrar', ['class' => 'form__label']) !!}
        {!! Form::number('tarifa', null, ['class' => 'form__input', 'required']) !!}
    </div>


    <div class="form__field full-width">
            <fieldset>
                <legend>Detalle Factura</legend>
                <div class="table">
                    <div class="table__row table__header">
                        <div class="table__cell">Detalle</div>
                        <div class="table__cell">Cantidad</div>
                        <div class="table__cell">Precio (% del total)</div>
                    </div>
                </div>
                <div class="controles">
                    <a class="btn btn--xsmall btn--square" id="addRow">+</a>
                    <a class="btn btn--xsmall btn--red btn--square" id="delRow">-</a>
                </div>
            </fieldset>
    </div>
    <input type="hidden" value="0" name="num_detalles" id="num_detalles">
        
    <div class="form__field">
        <button class="btn">Agregar</button>
    </div>
{!! Form::close() !!}