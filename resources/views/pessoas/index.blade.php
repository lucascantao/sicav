@extends('app')
@section('title', 'pessoas')
@section('content')

@php
    $breadcrumb = [
        'icon' => 'people-fill',
        'breadcrumbs' => [
            ['title' => 'Visitantes', 'url' => route('pessoa.index')]
        ]
    ];
@endphp

@include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

<div class="card border-0 accordion m-4" id="accordionFiltro">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                <span><i class="bi bi-search me-2"></i></span>Pesquisar Visitante
            </button>
        </h2>

        <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFiltro">
            <hr class="mx-3 my-0">
            <div class="accordion-body">
                <div class="row row-cos-6">
                    <div class="col-lg-4 col-md-4">
                        <b><label for="nome" class="form-label">Nome</label></b>
                        <input id="nome" name="nome" type="text" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <b><label for="tipo_documento" class="form-label">Tipo do Documento</label></b>
                        <select class="form-select" name="tipo_documento" id="tipo_documento">
                            <option selected value="">Selecionar</option>
                            <option value="CPF">CPF</option>
                            <option value="Passaporte">Passaporte</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <b><label for="documento" class="form-label">Nº Documento</label></b>
                        <input id="documento" name="documento" type="text" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <b><label for="data_nascimento" class="form-label">Data de Nascimento</label></b>
                        <input id="data_nascimento" name="data_nascimento" type="date" class="form-control">
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <b><label for="telefone1" class="form-label">Celular</label></b>
                        <input id="telefone1" type="text" class="form-control">
                    </div>
                    <div>
                        <button id="button_search" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-search"></i> Filtrar</button>
                        <button id="button_clear" type="button" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-eraser"></i> Limpar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 card-body m-4 px-6 py-6">
    <div>
        @if(session()->has('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <span>Relação de Visitantes</span>
    <hr>
    <div>
        <a class="col-lg-2 btn btn-semas mb-2" href="{{route('pessoa.create')}}" role="button"><i class="bi bi-plus-circle"></i> Novo Visitante</a>
        <button class="col-lg-2 btn btn-semas-secondary mb-2" id="botaoRelatorio"><i class="bi bi-file-earmark-ruled me-2"></i>Gerar relatório</button>
    </div>
    <div class="table-container">
        <table id="pessoa_table" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Nome</th> {{-- 0 --}}
                    <th scope="col" class="text-center">Tipo do Documento</th> {{-- 1 --}}
                    <th scope="col" class="text-center">Documento</th> {{-- 2 --}}
                    <th scope="col" class="text-center">Data de Nascimento</th> {{-- 3 --}}
                    <th scope="col" class="text-center">Celular</th> {{-- 4 --}}
                    <th scope="col" class="text-center">Ações</th> {{-- 7 --}}
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('components.modal-delete')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.2/js/dataTables.dateTime.min.js"></script>

<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

<script>
    var pessoa_table = $('#pessoa_table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: '{{ route("pessoa.data") }}',
            data: function(d) {
                d.nome = $('#nome').val();
                d.tipo_documento = $('#tipo_documento').val();
                d.numero_documento = $('#documento').val();
                d.data_nascimento = $('#data_nascimento').val();
                d.telefone1 = $('#telefone1').val();
            },
        },
        order: [
            [0, 'desc'],
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/pt-BR.json',
        },
        columns: [
            { data: 'nome', name: 'nome' },
            { data: 'tipo_documento', name: 'tipo_documento', className: 'text-center' },
            { data: 'documento', name: 'documento', className: 'text-center' },
            { data: 'data_nascimento', name: 'data_nascimento', className: 'text-center' },  // Ordenação automática pelo atributo data-order
            { data: 'telefone1', name: 'telefone1', className: 'text-center' },
            { data: 'acao', className: 'text-center', orderable: false, searchable: false }
            // {
            //     data: 'data',
            //     render: function(data) {
            //         return new Date(data + ' 00:00:00').toLocaleString().substring(0, 10);
            //     },
            //     className: 'text-center'
            // },
        ],
        layout: {
            topEnd: {
                pageLength: {
                    menu: [5, 10, 25, 50]
                },
            },
            topStart: false
        },
    });

    $(document).ready(function(){
        $('.telefone').each(function() {
            var telefone = $(this).text().trim();
            if (telefone.length === 10) {
                var telefoneMascarado = telefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            } else if (telefone.length === 11) {
                var telefoneMascarado = telefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else {
                var telefoneMascarado = telefone;
            }
            $(this).text(telefoneMascarado);
        });

        $('.data-nascimento').each(function() {
            var data = $(this).text().trim();
            if (data.match(/^\d{4}-\d{2}-\d{2}$/)) {
                var dataMascarada = data.replace(/(\d{4})-(\d{2})-(\d{2})/, '$3/$2/$1');
            } else {
                var dataMascarada = data;
            }
            $(this).text(dataMascarada);
        });

        $('.documento').each(function() {
            var documento = $(this).text().trim();
            if (documento.length === 11) {
                var documentoMascarado = documento.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else {
                var documentoMascarado = documento;
            }
            $(this).text(documentoMascarado);
        });

        $('#button_search').on('click', function() {
            pessoa_table.ajax.reload();
        });

        $('#button_clear').on('click', function() {
            $('#nome').val('');
            $('#tipo_documento').val('');
            $('#documento').val('');
            $('#data_nascimento').val('');
            $('#telefone1').val('');

            pessoa_table.search('').columns().search('').draw();
        });

        telefone = IMask(document.getElementById('telefone1'), {
            mask: '(00) 00000-0000'
        });

        var documento = IMask(document.getElementById('documento'), {
            mask: /[\s\S]*/
        });

        $('#tipo_documento').on('change', function(){
            documento.updateValue();
            // $('#documento').val('');
            $('#documento').focus();

            if ($('#tipo_documento').val() == 'CPF') {
                documento.updateOptions({ mask: '000.000.000-00' });
            } else {
                documento.updateOptions({
                        mask: /[\s\S]*/,
                });
            }
        });

        $('#botaoRelatorio').on('click', function(e) {
            e.preventDefault();

            $('.overlay').removeClass('d-none');

            var nome = $('#nome').val();
            var tipo_documento = $('#tipo_documento').val();
            var documento = $('#documento').val();
            var data_nascimento = $('#data_nascimento').val();
            var telefone1 = $('#telefone1').val();
            var ordem = pessoa_table.order();

            $.ajax({
                url: '{{ route("pessoa.table") }}',
                method: 'get',
                data: {
                    nome: nome,
                    tipo_documento: tipo_documento,
                    documento: documento,
                    data_nascimento: data_nascimento,
                    telefone1: telefone1,
                    ordem: ordem
                },
                success: function(response) {
                    var newWindow = window.open('_blank');
                    newWindow.document.write(response);
                    newWindow.document.close();
                    $('.overlay').addClass('d-none');
                },
                error: function(response) {
                    $('.overlay').addClass('d-none');
                }
            });
        });
    });

    $('#nome').focus();
</script>

@endsection
