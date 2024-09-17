@extends('app')
@section('title', 'empresas')
@section('content')

    @php
        $breadcrumb = [
                    'icon' => 'building-fill',
                    'breadcrumbs' => [
                        ['title' => 'Empresas', 'url' => route('empresa.index')]
                    ]
                ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

<div class="card border-0 accordion m-4" id="accordionFiltro">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                <span><i class="bi bi-search me-2"></i></span>Pesquisar Empresa
            </button>
        </h2>
        <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFiltro">
            <hr class="mx-3 my-0">
            <div class="accordion-body">
                <div class="row row-cos-6">
                    <div class="col-5">
                        <b><label for="empresa_nome" class="form-label">Nome</label></b>
                        <input id="nome" name="empresa_nome" type="text" class="form-control text-uppercase">
                    </div>
                    <div class="col-4">
                        <b><label for="empresa_cnpj" class="form-label">CNPJ</label></b>
                        <input id="cnpj" name="empresa_cnpj" type="text" class="form-control text-uppercase">
                    </div>
                    <div class="col-3">
                        <b><label for="empresa_tel_contato" class="form-label">Telefone de Contato</label></b>
                        <input id="tel_contato" name="empresa_tel_contato" type="text" class="form-control text-uppercase">
                    </div>
                </div>
                <div>
                    <button id="button_clear" type="button" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-eraser"></i> Limpar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 card-body m-4 px-6 py-6">

    @include('components.notification')

    <span>Relação de Empresas</span>
    <hr>
    <div>
        @if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) {{-- master , Agente Portaria--}}
            <a class="col-lg-2 btn btn-semas mb-2" href="{{route('empresa.create')}}" role="button"><i class="bi bi-plus-circle"></i> Cadastrar</a>
        @endif
        <button class="col-lg-2 btn btn-semas-secondary mb-2" id="botaoRelatorio"><i class="bi bi-file-earmark-ruled me-2"></i>Gerar relatório</button>
    </div>
    <table id="empresa_table" class="table table-hover">
        <thead>
            <tr>
                {{-- <th scope="col">#</th> --}}
                <th scope="col">Nome</th>
                <th scope="col" class="text-center">CNPJ</th>
                <th scope="col" class="text-center">Telefone</th>
                <th scope="col" class="text-center">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empresas as $empresa)
            <tr>
                {{-- <td>{{$empresa->id}}</td> --}}
                <td>{{$empresa->nome}}</td>
                <td class="text-center">{{ $empresa->cnpj }}</td>
                <td class="text-center telefone-td">{{ $empresa->tel_contato }}</td>
                <td class="text-center" style="white-space: nowrap !important">
                    <a class="btn btn-opaque-semas me-2" href="{{route('empresa.show', ['empresa' => $empresa])}}"><span><i class="bi bi-eye-fill"></i></span></a>
                    @if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) {{-- master --}}
                    <a class="btn btn-opaque-semas me-2" href="{{route('empresa.edit', ['empresa' => $empresa])}}"><span><i class="bi bi-pencil-fill"></i></span></a>
                    @endif
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($empresa->deleted_at))
                                @php
                                $arr = json_encode([
                                    'id' => $empresa->id,
                                    'message' => 'Deseja mesmo exluir a empresa' . $empresa->nome . ' ?',
                                    'route' => route('empresa.destroy', ['id' => $empresa->id])
                                ]);
                                @endphp
                            <label onclick="modalDelete({{$arr}})" class="btn btn-opaque-semas-danger me-1"><span><i class="bi bi-trash-fill"></i></span></label>
                        @else
                            <a class="btn btn-opaque-semas me-1" href="{{route('empresa.enable', ['id' => $empresa->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i></span></a>
                        @endif
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @include('components.modal-delete')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/imask"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
    var empresaTable = new DataTable('#empresa_table', {
        order: [
            [0, 'asc']
        ],
        columnDefs: [
            // {target: 0, visible: false},

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
                        columns: [1]
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
                                '<center><h4>RELAÇÃO DE EMPRESAS</h4></center>'
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

    document.addEventListener('DOMContentLoaded', function() {
        IMask(document.getElementById('cnpj'), {
            mask: '00.000.000/0000-00'
        });
        // IMask(document.getElementById('tel_contato'), {
        //     mask: '(00) 00000-0000'
        // });

        $('.telefone-td').each(function() {
            var telContato = $(this).text().trim();
            var telContatoMascara = telContato.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            $(this).text(telContatoMascara);
        });
    });

    $('#nome').focus();

    $('#nome').on('keyup', function() {
        empresaTable.column(0).search(this.value).draw();
    });

    $('#cnpj').on('keyup', function() {
        empresaTable.column(1).search(this.value).draw();
    });

    $('#tel_contato').on('keyup', function() {
        empresaTable.column(2).search(this.value).draw();
    });

    $('#button_clear').on('click', function() {
        $('#nome').val('');
        $('#cnpj').val('');
        $('#tel_contato').val('');

        empresaTable.search('').columns().search('').draw();
    });

    $(document).ready(function(){
    $('#botaoRelatorio').on('click', function(e) {
        e.preventDefault();

        $('.overlay').removeClass('d-none');

        var nome = $('#nome').val();
        var cnpj = $('#cnpj').val();
        var tel_contato = $('#tel_contato').val();

        var ordem = empresaTable.order();

        $.ajax({
            url: '{{ route('empresa.gerarRelatorio') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                nome: nome,
                cnpj: cnpj,
                tel_contato: tel_contato,
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
