{!! Form::open(['class' => 'form', 'id' => 'servicioData', 'method' => $method, 'action' => $action]) !!}

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
    <input type="hidden" name="tipo_servicio" value="{{ $action['servicio'] }}">
            
    <div class="form__field">
        <button class="btn">Guardar</button>
    </div>

{!! Form::close() !!}