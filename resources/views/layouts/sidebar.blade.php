<div class="d-flex flex-column fixed-top" id="sidebar">
    <img id="sidebar-img" src="{{asset('images/sidebar-v3.png')}}">
    <div class="d-flex justify-content-between align-middle p-3 text-white">
        MENU
    </div>
    <ul class="nav nav-pills flex-column">

        @if (Auth::user()->perfil->nome == 'Agente Portaria' ||
            Auth::user()->perfil->nome == 'Auditor' ||
            Auth::user()->perfil->nome == 'Master'
        )

            <li>
                <a href="{{route('pessoa.index')}}" class="nav-link text-white align-middle">
                    <i class="bi bi-people-fill"></i>
                    <span>Visitantes</span>
                </a>
            </li>

            <li>
                <a href="{{route('visita.index')}}" class="nav-link text-white align-middle">
                    <i class="bi bi-calendar"></i>
                    <span>Visitas</span>
                </a>
            </li>

            <li>
                <a href="{{route('empresa.index')}}" class="nav-link text-white align-middle">
                    <i class="bi bi-building-fill"></i>
                    <span>Empresas</span>
                </a>
            </li>

            
            @if (Auth::user()->perfil->nome == 'Master' || Auth::user()->perfil->nome == 'Auditor')
                @if (Auth::user()->perfil->nome == 'Master')

                    <li>
                        <a href="{{route('user.index')}}" class="nav-link text-white align-middle">
                            <i class="bi bi-people-fill"></i>
                            <span>Usuários</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{route('setor.index')}}" class="nav-link text-white align-middle">
                        <i class="bi bi-archive-fill"></i>
                        <span>Setores</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('unidade.index')}}" class="nav-link text-white align-middle">
                        <i class="bi bi-buildings-fill"></i>
                        <span>Unidades</span>
                    </a>
                </li>
            @endif
        @endif
    </ul>
</div>
