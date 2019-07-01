<div class="table">
    <div class="table__row table__header">
        <div class="table__cell">Servicio</div>
        <div class="table__cell">Folio Factura</div>
        <div class="table__cell">Fecha Emisión</div>
        <div class="table__cell">Fecha Vencimiento</div>
        <div class="table__cell">Neto</div>
        <div class="table__cell">IVA</div>
        <div class="table__cell">Total</div>
        <div class="table__cell"></div>
    </div>

    @forelse ($facturas as $factura)
    <div class="table__row">
        <div class="table__cell">{{ $factura->servicios__tipo_servicio }}</div>
        <div class="table__cell">{{ str_pad($factura->folio, 5, '0', STR_PAD_LEFT) }}</div>
        <div class="table__cell">{{ $factura->fechaEmision }}</div>
        <div class="table__cell">{{ $factura->fechaVencimiento }}</div>
        <div class="table__cell">{{ number_format($factura->neto, 0, ',', '.') }}</div>
        <div class="table__cell">{{ number_format($factura->iva, 0, ',', '.') }}</div>
        <div class="table__cell">{{ number_format($factura->total, 0, ',', '.') }}</div>
        <div class="table__cell"><a class="btn btn--md" href="{{ action('FacturaController@show', 
                                        ['servicio' => $factura->servicios__tipo_servicio, 'folio' => $factura->folio]) }}">Ver Factura
        </a></div>
    </div>
    @empty
    <div class="table__row"><div class="table__cell">Sin facturas.</div></div>
    @endforelse
</div>