<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencial {{$contribuyente->razon_social}}</title>
    <link rel="stylesheet" href="{{ asset('css/credencial.css')}}">
    <style>
        html,body {
            display: block;
            position: relative;
        }
    </style>
</head>
<body>
    <div class="credencial">
    <div class="card">
        <div class="card__header">
            <span>Rol Único Tributario</span>
        </div>
        <div class="card__content">
            <div class="card__section">
                <div class="card__title txt-bolder">
                    <span>Nombre o Razón Social</span>
                </div>
                <div class="card__text txt-bolder">
                    <span>{{ $contribuyente->razon_social }}</span>
                </div>
            </div>
            <div class="card__section">
                <div class="card__title txt-bolder">
                    <span>Dirección</span>
                </div>
                <div class="card__text direccion">
                    <span>{{ $contribuyente->domicilio }}</span>
                </div>
            </div>
            <div class="card__section">
                
                <table style="width:100%">
                    <tr>
                        <td>
                            <div class="card__title txt-bolder inline"><span>RUT</span></div>
                            <div class="card__text txt-bolder inline rut">{{ number_format($contribuyente->rut, 0, ',', '.') }}-{{ $contribuyente->dig_verificador}}</div>
                        
                        </td>
                        <td class="card__logo">
                            <img src="{{ asset('images/cfe_logo.png')}}" alt="Logo SII">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>
</html>