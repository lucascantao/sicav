@extends('app')
@section('title', 'usuarios')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'people-fill',
        'breadcrumbs' => [
            ['title' => 'Usuarios', 'url' => route('user.index')]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

<div class="card border-0 accordion m-4" id="accordionFiltro">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                <span><i class="bi bi-search me-2"></i></span>Pesquisar Usuário
            </button>
        </h2>
        <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFiltro">
            <hr class="mx-3 my-0">
            <div class="accordion-body">
                <div id="filtro" class="row row-cos-6">
                    <div class="col-4">
                        <b><label for="usuario_nome" class="form-label">Nome</label></b>
                        <input id="nome" type="text" class="form-control">
                    </div>

                    <div class="col-4">
                        <b><label for="usuario_setor" class="form-label">Setor</label></b>
                        <input class="form-control" id="setor" list="options" name="setor" autocomplete="off">
                        <datalist id="options">
                            @foreach ($setores as $setor)
                                <option  >{{$setor->sigla}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-2">
                        <b><label for="usuario_perfil" class="form-label">Perfil</label></b>
                        <select class="form-select" name="perfil" id="perfil">
                            <option value="">Selecionar perfil</option>
                            @foreach ($perfis as $perfil)
                                <option value="{{$perfil->nome}}">{{$perfil->nome}}</option>
                            @endforeach
                            <option value="Sem perfil">Sem perfil</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <b><label for="usuario_status" class="form-label">Status</label></b>
                        <select class="form-select" name="status" id="status">
                            <option value="">Selecionar status</option>
                            <option value="habilitado">Habilitado</option>
                            <option value="desabilitado">Desabilitado</option>
                        </select>
                    </div>
                    <div>
                        <button id="button_clear" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-eraser"></i> Limpar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="card border-0 card-body m-4 px-6 py-6">

    @include('components.notification')

    <span>Relação de Usuários</span>
    <hr>
    <div>
        <button class="col-lg-2 btn btn-semas-secondary mb-2" id="botaoRelatorio"><i class="bi bi-file-earmark-ruled me-2"></i>Gerar relatório</button>
    </div>
    <table id="usuario_table" class="table table-hover">
        <thead>
            <tr>

                <th scope="col">#</th> {{-- 0 --}}
                <th scope="col">Nome</th> {{-- 1 --}}
                <th scope="col" class="text-center">Setor</th> {{-- 2 --}}
                <th scope="col" class="text-center">Perfil</th> {{-- 3 --}}
                <th scope="col" class="text-center">Status</th> {{-- 4 --}}
                <th scope="col" class="text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td class="text-center">{{$user->setor->sigla}}</td>
                @if ($user->perfil_id != null)
                    <td class="text-success fw-bold text-center">{{$user->perfil->nome}}</td>
                @else
                    <td class="text-warning text-center">Sem perfil</td>
                @endif
                @if ($user->deleted_at != null)
                    <td class="text-danger text-center">Desabilitado</td>
                @else
                    <td class="text-success text-center">Habilitado</td>
                @endif
                <td class="text-center">
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        <a class="btn btn-opaque-semas me-2" href="{{route('user.show', ['user' => $user])}}"><span><i class="bi bi-eye-fill"></i></span></a>
                        <a class="btn btn-opaque-semas me-2" href="{{route('user.edit', ['id' => $user->id])}}"><span><i class="bi bi-pencil-fill"></i></span></a>

                        @if (empty($user->deleted_at))
                            @php
                                $arr = json_encode([
                                    'id' => $user->id,
                                    'message' => 'Deseja mesmo exluir a usuário ' . $user->nome . ' ?',
                                    'route' => route('user.destroy', ['id' => $user->id])
                                ]);
                            @endphp
                            <label onclick="modalDelete({{$arr}})" class="btn btn-opaque-semas-danger me-1"><span><i class="bi bi-trash-fill"></i></span></label>
                        @else
                            <a class="btn btn-opaque-semas me-1" href="{{route('user.enable', ['id' => $user->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i></span></a>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @include('components.modal-delete')
</div>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>

    var usuario_table = $('#usuario_table').DataTable({

        // Tradução
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/pt-BR.json',
        },
        order: [
            [1, 'asc']
        ],
        columnDefs: [
            {target: 0, visible: false},
            {target: 5, orderable: false},
        ],
        fixedHeader: {
            header:true,
            footer: true,
        },
        // Remover controles padrão
        layout: {
                topEnd: {
                    pageLength: {
                        menu: [5, 10, 25, 50]
                    }
                },

                topStart: {
                    buttons: [
                    {
                        extend: 'print',
                        class: 'buttons-print',
                        //Esconder o botão padrão de print do datatables
                        init: function(api, node, config) {
                            $(node).hide();
                        },
                        exportOptions: {
                            columns: [1, 2, 3] // Índices das colunas que serão impressas (começando em 0)
                        },
                        title: '',
                        autoPrint: false, // Evita a impressão automática
                        footer: true, // Habilita o footer
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '12pt')
                                .prepend(
                                    '<center><img src="{{asset('images/brasao-pa.png')}}" width="100px"  /></center>',
                                    '<center><h6>GOVERNO DO ESTADO DO PARÁ</h6></center>',
                                    '<center><h6>SECRETARIA DE MEIO AMBIENTE E SUSTENTABILIDADE</h7></center>',
                                    '<BR><BR>',
                                    '<center><h4>RELAÇÃO DE USUARIOS</h4></center>'
                                );

                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');

                            // Adiciona o conteúdo do footer ao documento de impressão
                            $(win.document.body).append('<div style="text-align:center;margin-top:100px;">DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</div>');

                        }
                    }]
                }
            },
        });

    //Focus no primeiro campo
    $('#nome').focus();

    $('#nome').on('keyup', function() {
        usuario_table.column(1).search(this.value).draw();
    })
    $('#setor').on('change', function() {
        usuario_table.column(2).search(this.value).draw();
    })
    $('#perfil').on('change', function() {
        usuario_table.column(3).search(this.value).draw();
    })
    $('#status').on('change', function() {
        usuario_table.column(4).search(this.value).draw();
    })

    $(document).ready(function(){
    $('#botaoRelatorio').on('click', function(e) {
        e.preventDefault();

        $('.overlay').removeClass('d-none');

        var nome = $('#nome').val();
        var setor = $('#setor').val();
        var perfil = $('#perfil').val();
        var status = $('#status').val();

        var ordem = usuario_table.order();

        $.ajax({
            url: '{{ route('user.gerarRelatorio') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nome: nome,
                setor: setor,
                perfil: perfil,
                status: status,
                ordem: ordem
            },
            success: function(response) {
                var newWindow = window.open('_blank');
				newWindow.document.write(response);
				newWindow.document.close();
                $('.overlay').addClass('d-none');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                $('.overlay').addClass('d-none');
            }
        });
    });
});

    $('#button_clear').on('click', function() {

        $('#filtro select').each( function () {
            $(this).val($(this).find('option[selected]').val());
        });

        $('#filtro input').each(function() {
            $(this).val('');
        });
        usuario_table.search('').columns().search('').draw();
    });
</script>
@endsection
