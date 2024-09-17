@extends('app')
@section('title', 'visitas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'calendar',
        'breadcrumbs' => [
            ['title' => 'Visitas', 'url' => route('visita.index')],
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div class="card border-0 accordion m-4" id="accordionFiltro">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="true" aria-controls="collapse">
                    <span><i class="bi bi-search me-2"></i></span>Pesquisar
                </button>
            </h2>

            <div id="collapse" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionFiltro">
                <hr class="mx-3 my-0">
                <div class="accordion-body">
                    <div id="filtro" class="row">
                        <div class="col-lg-4 col-md-4">
                            <b><label for="visitante" class="form-label">Visitante</label></b>
                            <input id="visitante" name="visitante_nome" type="text" class="form-control">
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <b><label for="tipo_documento" class="form-label">Tipo de Documento</label></b>
                            <select class="form-select" id="tipo_documento" name="visitante_tipo_documento" type="text" class="form-control">
                                <option selected value="">Selecionar</option>
                                <option>CPF</option>
                                <option>PASSAPORTE</option>
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <b><label for="documento" class="form-label">Documento</label></b>
                            <input id="documento" name="visitante_documento" type="text" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12">
                            <b><label for="telefone" class="form-label">Telefone</label></b>
                            <input id="telefone" name="visitante_telefone1" type="text" class="form-control">
                        </div>
                    </div>
                    <div id="filtro" class="row">
                        <div class="col-lg-4 col-md-4">
                            <b><label for="setor" class="form-label">Setor</label></b>
                            <input class="form-control" id="setor" list="options" name="setor" autocomplete="off">
                            <datalist id="options">
                                @foreach ($setores as $setor)
                                    <option  >{{$setor->sigla}}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <b><label for="servidor" class="form-label">Servidor</label></b>
                            <input id="servidor" name="visitante_servidor" type="text" class="form-control">
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <div class="row">
                                <div class="col">
                                    <b><label class="form-label" for="date_start">Data Início</label></b>
                                    <input class="form-control" name="visitante_data_inicio" type="text" placeholder="--/--/--" id="date_start" name="date_start">
                                </div>
                                <div class="col">
                                    <b><label class="form-label" for="date_end">Data fim</label></b>
                                    <input class="form-control" name="visitante_data_final" type="text" placeholder="--/--/--" id="date_end" name="date_end">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button id="button_search" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-search"></i> Filtrar</button>
                        <button id="button_clear" class="col-lg-2 btn btn-outline-semas mt-4"><i class="bi bi-eraser"></i> Limpar</button>
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
        <span>Relação de visitas</span>
        <hr>
        <div>
            <button class="col-lg-2 btn btn-semas-secondary mb-2" id="botaoRelatorio"><i class="bi bi-file-earmark-ruled me-2"></i>Gerar relatório</button>
        </div>
        <div class="table-container">
            <table id="visita_table" class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Visitante</th> {{-- 0 pessoa_id --}}
                        <th scope="col" class="text-center">Tipo de Documento</th> {{-- 1 pessoa->documento --}}
                        <th scope="col" class="text-center">Documento</th> {{-- 2 pessoa->documento --}}
                        {{-- <th scope="col">Documento_Hidden</th> 2 --}}
                        {{-- <th scope="col" class="text-center">Telefone</th> 2 pessoa->telefone --}}
                        {{-- <th scope="col" class="text-center">Data_Hidden</th>4 data_hidden --}}
                        <th scope="col" class="text-center">Data</th> {{-- 3 created_at --}}
                        <th scope="col" class="text-center">Setor</th> {{-- 4 setor_id --}}
                        <th scope="col">Servidor</th> {{-- 5 servidor_id --}}
                        <th scope="col" class="text-center">Ações</th> {{-- 6 --}}
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            @include('components.modal-delete')
        </div>
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
        minDate = new DateTime('#date_start', {
            format: 'DD/MM/YYYY'
        });

        maxDate = new DateTime('#date_end', {
            format: 'DD/MM/YYYY'
        });

        var visita_table = $('#visita_table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: '{{ route("visita.data") }}',
                data: function(d) {
                    d.nome = $('#visitante').val();
                    d.tipo_documento = $('#tipo_documento').val();
                    d.numero_documento = $('#documento').val();
                    d.telefone = $('#telefone').val();
                    d.setor = $('#setor').val();
                    d.servidor = $('#servidor').val();
                    d.data_inicio = $('#date_start').val();
                    d.data_fim = $('#date_end').val();
                },
            },
            columns: [
                { data: 'nome', name: 'nome' },
                { data: 'tipo_documento', name: 'tipo_documento', className: 'text-center' },
                { data: 'documento', name: 'documento', className: 'text-center' },
                // { data: 'telefone1', name: 'telefone1', className: 'text-center' },
                { data: 'created_at_formatada', name: 'created_at', className: 'text-center' },
                { data: 'sigla', name: 'sigla', className: 'text-center' },  // Ordenação automática pelo atributo data-order
                { data: 'servidor', name: 'servidor', className: 'text-center' },  // Ordenação automática pelo atributo data-order
                { data: 'acao', className: 'text-center', orderable: false, searchable: false }

            ],

            order: [
                [0, 'desc']
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.0.3/i18n/pt-BR.json',
            },
            columnDefs: [
                // {target: 2, visible: false, searchable: true},
                {target: 6, orderable: false}
            ],
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
                            exportOptions: {
                                columns: [0,1,3,4,5]
                            },
                            init: function(api, node, config) {
                                $(node).hide();
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
                                        '<center><h6>SECRETARIA DE MEIO AMBIENTE E SUSTENTABILIDADE</h6></center>',
                                        '<br><br>',
                                        '<center><h4>RELAÇÃO DE VISITAS</h4></center>'
                                    );

                                $(win.document.body)
                                    .find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');

                                $(win.document.body).append('<div style="text-align:center;margin-top:100px;">DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</div>');
                            },
                        }
                    ]
                }
            },
        });

        $('#visitante').focus();

        $('#button_search').on('click', function() {
            visita_table.ajax.reload();
        });

        $('#button_clear').on('click', function() {
            $('#filtro select').each(function () {
                $(this).val($(this).find('option[selected]').val());
            });

            $('#filtro input').each(function() {
                $(this).val('');
            });
            visita_table.search('').columns().search('').draw();
        });

        telefone = IMask(document.getElementById('telefone'), {
            mask: '(00) 00000-0000'
        });

        $(document).ready(function(){
            $('#botaoRelatorio').on('click', function(e) {
                e.preventDefault();

                $('.overlay').removeClass('d-none');

                var visitante = $('#visitante').val();
                var tipo_documento = $('#tipo_documento').val();
                var documento = $('#documento').val();
                var telefone = $('#telefone').val();
                var setor = $('#setor').val();
                var servidor = $('#servidor').val();
                var date_inicio = $('#date_start').val();
                var date_fim = $('#date_end').val();

                var ordem = visita_table.order();

                $.ajax({
                    url: '{{ route('visita.table') }}',
                    method: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}',
                        visitante: visitante,
                        tipo_documento: tipo_documento,
                        documento: documento,
                        telefone: telefone,
                        setor: setor,
                        servidor: servidor,
                        date_inicio: date_inicio,
                        date_fim: date_fim,
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
