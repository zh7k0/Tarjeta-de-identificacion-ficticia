<aside class="navbar">
    <ul class="navbar-wrapper">
        <li class="navbar__link navbar__link--bg-white">
            <img src="{{ asset('images/virginio_logo.jpg')}}" alt="Logo Virginio">
            <img src="{{ asset('images/CFE_logo.png') }}" alt="Logo Empresa Simulada">
        </li>
        <li class="navbar__link"><a href="{{ route('lista_contribuyentes') }}">Empresas</a></li>
        <li class="navbar__link"><a href="{{ action('GiroController@index')}}">Giros</a></li>
    </ul>
</aside>