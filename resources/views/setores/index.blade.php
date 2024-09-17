@extends('app')
@section('title', 'setores')
@section('content')

@php
    $breadcrumb = [
        'icon' => 'archive-fill',
        'breadcrumbs' => [
            ['title' => 'Setores', 'url' => route('setor.index')]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

<div class="card border-0 accordion m-4" id="accordionFiltro">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                <span><i class="bi bi-search me-2"></i></span>Pesquisar Setor
            </button>
        </h2>
        <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFiltro">
            <hr class="mx-3 my-0">
            <div class="accordion-body">
                <div class="row row-cos-6">
                    <div class="col-2">
                        <label for="setor_sigla" class="form-label">Sigla</label>
                        <input id="sigla" name="setor_sigla" type="text" class="form-control text-uppercase">
                    </div>
                    <div class="col-10">
                        <label for="setor_nome" class="form-label">Nome</label>
                        <input id="nome" name="setor_nome" type="text" class="form-control text-uppercase">
                    </div>
                    <div class="col-12">
                        <button id="button_clear" type="button" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-eraser"></i> Limpar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 card-body m-4 px-6 py-6">

    @include('components.notification')

    <span>Relação de Setores</span>
    <hr>
    <div>
        @if (Auth::user()->perfil_id == 3) {{-- master --}}
            <a class="col-lg-2 btn btn-semas mb-2" href="{{route('setor.create')}}" role="button"><i class="bi bi-plus-circle"></i> Cadastrar</a>
        @endif
        <button class="col-lg-2 btn btn-semas-secondary mb-2" id="botaoRelatorio"><i class="bi bi-file-earmark-ruled me-2"></i>Gerar relatório</button>
    </div>
    <table id="setor_table" class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" class="text-center">Sigla</th>
                <th scope="col">Nome</th>
                <th scope="col" class="text-center col-2">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($setores as $setor)
            <tr>
                <td>{{$setor->id}}</td>
                <td class="text-center">{{$setor->sigla}}</td>
                <td>{{$setor->nome}}</td>
                <td class="text-center" style="white-space: nowrap !important">
                    <a class="btn btn-opaque-semas me-2" href="{{route('setor.show', ['setor' => $setor])}}"><span><i class="bi bi-eye-fill"></i></span></a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($setor->deleted_at))
                            @php
                                $arr = json_encode([
                                    'id' => $setor->id,
                                    'message' => 'Deseja mesmo exluir a setor' . $setor->nome . ' ?',
                                    'route' => route('setor.destroy', ['id' => $setor->id])
                                ]);
                            @endphp
                            <label onclick="modalDelete({{$arr}})" class="btn btn-opaque-semas-danger me-1"><span><i class="bi bi-trash-fill"></i></span></label>
                        @else
                            <a class="btn btn-opaque-semas me-1" href="{{route('setor.enable', ['id' => $setor->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i></span></a>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @include('components.modal-delete')
</div>

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
    var setorTable = new DataTable('#setor_table', {
        order: [
            [1, 'asc']
        ],
        columnDefs: [
            {target: 0, visible: false},
            {target: 1, orderable: true},
            {target: 2, orderable: true},
            {
                target: 3,
                orderable: false,
                className: 'action'
            },
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/pt-BR.json',
        },
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
                        init: function(api, node, config) {
                            $(node).hide();
                        },
                        exportOptions: {
                            columns: [1, 2]
                        },
                        title: '',
                        autoPrint: false,
                        footer: true,
                        customize: function (win) {
                            $(win.document.body)
                                .css('font-size', '12pt')
                                .prepend(
                                    '<center><img src="{{asset('images/brasao-pa.png')}}" width="100px"  /></center>',
                                    '<center><h6>GOVERNO DO ESTADO DO PARÁ</h6></center>',
                                    '<center><h6>SECRETARIA DE MEIO AMBIENTE E SUSTENTABILIDADE</h7></center>',
                                    '<BR><BR>',
                                    '<center><h4>RELAÇÃO DE SETORES</h4></center>'
                                );

                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');

                            $(win.document.body).append('<div style="text-align:center;margin-top:100px;">DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</div>');

                        }
                    }]
                }
            }
        });

    $('#sigla').on('keyup', function() {
        setorTable.column(1).search(this.value, false, false).draw();
    });

    $('#nome').on('keyup', function() {
        setorTable.column(2).search(this.value, false, false).draw();
    });

    $('#button_clear').on('click', function() {
        $('#sigla').val('');
        $('#nome').val('');

        setor_table.search('').columns().search('').draw();
        });

    $(document).ready(function(){
    $('#botaoRelatorio').on('click', function(e) {
        e.preventDefault();

        $('.overlay').removeClass('d-none');

        var sigla = $('#sigla').val();
        var nome = $('#nome').val();

        var ordem = setorTable.order();

        $.ajax({
            url: '{{ route('setor.gerarRelatorio') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                sigla: sigla,
                nome: nome,
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

</script>
@endsection
