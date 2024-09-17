@extends('app')
@section('title', 'pessoas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'people-fill',
        'breadcrumbs' => [
            ['title' => 'Visitantes', 'url' => route('pessoa.index')],
            ['title' => 'Datalhes', 'url' => route('pessoa.show', ['pessoa' => $pessoa['id']])]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome"><b>Nome</b></label><br>
                    <label class="form-label" for="nome">{{$pessoa['nome']}}</label>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="form-label" for="tipo_documento"><b>Tipo de Documento</b></label><br>
                    <label class="form-label" for="tipo_documento">{{$pessoa['tipo_documento']}}</span></label>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="form-label" for="documento"><b>Nº Documento</b></label><br>
                    <label class="form-label" for="documento">{{$pessoa['documento']}}</label>
                </div>
            </div>
            <div id="filtro" class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="email"><b>E-mail</b></label><br>
                    <label class="form-label" for="email">{{$pessoa['email']}}</label>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="form-label" for="sexo"><b>Sexo</b></label><br>
                    <label class="form-label" for="sexo">{{$pessoa['sexo']}}</label>
                </div>
                <div class="col-lg-3 col-md-4">
                    <label class="form-label" for="data_nascimento"><b>Data de Nascimento</b></label><br>
                    <label class="form-label" for="data_nascimento">{{$pessoa['data_nascimento']}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="telefone1"><b>Celular</b></label><br>
                    <label class="form-label" for="telefone1">{{$pessoa['telefone1']}}</label>
                </div>
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="telefone2"><b>Telefone</b></label><br>
                    <label class="form-label" for="telefone2">{{$pessoa['telefone2']}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4">
                    <label class="form-label" for="foto1"><b>Foto 1</b></label><br>
                    <img class="mt-2" width="100%" src="{{ asset($pessoa->foto1) }}" id="preview1" alt="">
                </div>
                <div class="col-lg-2 col-md-4">
                    <label class="form-label" for="foto2"><b>Foto 2</b></label><br>
                    <img class="mt-2" width="100%" src="{{ asset($pessoa->foto2) }}" id="preview2" alt="">
                </div>
            </div>

            <div class="mt-4">
                @if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) {{-- master --}}
                    <a class="col-2 btn btn-semas me-2" href="{{ route('visita.create', ['id' => $pessoa['id'] , 'nome' => $pessoa['nome'], 'documento' => $pessoa['documento']]) }}" title="Criar Visita">
                        <i class="bi bi-plus-circle"></i> Criar Visita
                    </a>
                    <a class="col-2 btn btn-semas me-2" href="{{ route('pessoa.edit', ['pessoa' => $pessoa]) }}" title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($pessoa->deleted_at))

                            @php
                                $deleteModalArr = json_encode([
                                    'id' => $pessoa->id,
                                    'message' => 'Deseja mesmo excluir a pessoa ' . $pessoa->nome . ' ?',
                                    'route' => route('pessoa.destroy', ['id' => $pessoa->id])
                                ]);
                            @endphp
                            <label onclick='modalDelete({{$deleteModalArr}})' class="col-2 btn btn-danger me-2"><span><i class="bi bi-trash-fill"></i> Deletar</span></label>
                            @include('components.modal-delete')
                        @else
                            <a class="col-2 btn btn-outline-secondary me-1" href="{{route('pessoa.enable', ['id' => $pessoa->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i> Habilitar</span></a>
                        @endif
                    @endif
                @endif
                <a href="{{ route('pessoa.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Voltar</a>
            </div>
        </div>
    </div>

    <script>
        // Máscara do telefone
        IMask(document.getElementById('telefone1'), {
            mask: '(00) 00000-0000'
        });

        IMask(document.getElementById('telefone2'), {
            mask: '(00) 00000-0000'
        });

        // Máscara do cpf
        var documento = IMask(document.getElementById('documento'), {
            mask: '000.000.000-00'
        });


        $('#tipo_documento').on('change', function(){
            $('#documento').val('');
            // Dá foco no campo "documento"
            $('#documento').focus();
           if( $('#tipo_documento').val()=='Passaporte'){

                documento.destroy();

           }
           if( $('#tipo_documento').val()=='CPF'){
                documento = IMask(document.getElementById('documento'), {
                    mask: '000.000.000-00'
                });

            }
        })
        //Buscando o valor anterior para a Preview das fotos
        $('#preview1').attr('src', $('#foto1').val())
        $('#preview2').attr('src', $('#foto2').val())


        $('#pessoa_formulario button[type="submit"]').click(function(event) {
            var tipoDocumento = $('#tipo_documento').val();
            var documento = $('#documento').val();

            if (tipoDocumento === 'CPF' && documento.length !== 14) {
                alert('O formato do CPF está invalido.');
                event.preventDefault(); // Impede a submissão do formulário
            }
        });

    </script>
@endsection
