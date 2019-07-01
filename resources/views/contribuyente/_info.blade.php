<div class="info">
    <div class="info__field">
        <label class="info__label">Nombre o Razón Social</label>
        <div class="info__data">{{ $contribuyente->razon_social }}</div>
    </div>
    <div class="info__field">
        <label class="info__label">RUT</label>
        <div class="info__data">{{ $contribuyente->rut }}</div>
    </div>
    <div class="info__field">
        <label class="info__label">Domicilio</label>
        <div class="info__data">{{ $contribuyente->domicilio }}</div>
    </div>
    <div class="info__field">
        <label class="info__label">Comuna</label>
        <div class="info__data">{{ $contribuyente->comuna }}</div>
    </div>
    <div class="info__field">
        <label class="info__label">Giro</label>
        <div class="info__data">{{ $contribuyente->giro->nombre }}</div>
    </div>
</div>