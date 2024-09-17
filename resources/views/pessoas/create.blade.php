@extends('app')
@section('title', 'pessoas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'people-fill',
        'breadcrumbs' => [
            ['title' => 'Visitantes', 'url' => route('pessoa.index')],
            ['title' => 'Cadastrar', 'url' => route('pessoa.create')]
        ]
    ];

    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            <form id="pessoa_formulario" method="post" action="{{route('pessoa.store')}}">
                @csrf
                @method('post')
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label" for="nome"><b>Nome</b><span style="color: red"> *</span></label>
                        <input class="form-control" name="nome" maxlength="250" type="text" placeholder="" value="{{old('nome')}}" required>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="form-label" for="tipo_documento"><b>Tipo de Documento</b><span style="color: red"> *</span></label>
                        <select value="{{old('tipo_documento')}}" class="form-select" name="tipo_documento" id="tipo_documento" required>
                            <option selected value="CPF">CPF</option>
                            <option value="Passaporte">Passaporte</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="form-label" for="documento"><b>Nº Documento</b><span style="color: red"> *</span></label>
                        <input value="{{old('documento')}}" id="documento" class="form-control" name="documento" maxlength="250" type="text" placeholder="" required>

                    </div>
                </div>
                <div id="filtro" class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label" for="email"><b>E-mail</b></label>
                        <input value="{{old('email')}}" class="form-control" name="email" maxlength="250" type="email" placeholder="" >
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="form-label" for="sexo"><b>Sexo</b><span style="color: red"> *</span></label>
                        <select value="{{old('sexo')}}" class="form-select" name="sexo" id="sexo" required>
                            <option selected value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <label class="form-label" for="data_nascimento"><b>Data de Nascimento</b><span style="color: red"> *</span> </label>
                        <input value="{{old('data_nascimento')}}" class="form-control" name="data_nascimento" id="data_nascimento" type="date" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label" for="telefone1"><b>Celular</b><span style="color: red"> *</span></label>
                        <input value="{{old('telefone1')}}" id="telefone1"class="form-control" name="telefone1" type="text" placeholder="(00) 00000-0000" required>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <label class="form-label" for="telefone2"><b>Telefone</b></label>
                        <input value="{{old('telefone2')}}" id="telefone2" class="form-control" name="telefone2" type="text" placeholder="(00) 0000-0000">
                    </div>
                </div>

                {{-- @include('components.modal-camera') --}}

                <div id="filtro" class="row">

                    <div class="col-lg-2 col-md-4">
                        <label class="form-label" for="foto1"><b>Foto 1</b><span style="color: red"> *</span></label>
                        <div>
                            <a onclick="openModal('foto1', 'preview1')" class="col-lg-12 col-md-12 btn btn-semas bi bi-camera"> Abrir Câmera</a>
                            @include('components.modal-camera')
                        </div>
                        <input value="{{old('foto1')}}" hidden id="foto1" class="form-control" name="foto1" type="text" placeholder="">
                        <img class="mt-2" width="100%" src="" id="preview1" alt="">
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <label class="form-label" for="foto2"><b>Foto 2</b><span style="color: red"> *</span></label>
                        <div>
                            <a onclick="openModal('foto2', 'preview2')" class="col-lg-12 col-md-12 btn btn-semas bi bi-camera"> Abrir Câmera</a>
                            @include('components.modal-camera')
                        </div>
                        <input value="{{old('foto2')}}" hidden id="foto2" class="form-control" name="foto2" type="text" placeholder="">
                        <img class="mt-2" width="100%" src="" id="preview2" alt="">
                    </div>


                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="usuario_cadastro_id"></label></b>
                        <input class="form-control" name="usuario_cadastro_id" type="hidden" value="{{ $id_usuario }}" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="col-2 btn btn-semas bi bi-floppy"> Salvar</button>
                    <a href="{{route('pessoa.index')}}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>

                </div>
            </form>
        </div>
    </div>

    <style>
        .disabled-select {
            pointer-events: none;
            background-color: #e9ecef;
        }
    </style>

    <script>

        // Máscara do telefone
        IMask(document.getElementById('telefone1'), {
            mask: '(00) 00000-0000'
        });

        IMask(document.getElementById('telefone2'), {
            mask: '(00) 0000-0000'
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


        // $('#pessoa_formulario button[type="submit"]').click(function(event) {
        //     var tipoDocumento = $('#tipo_documento').val();
        //     var documento = $('#documento').val();
        //     var foto1 = $('#foto1').val();
        //     var foto2 = $('#foto2').val();

        //     if (tipoDocumento === 'CPF' && documento.length !== 14) {
        //         //alert('O formato do CPF está invalido.');
        //         $('#aviso_cpf').removeClass('d-none');
        //         setTimeout(() => {
        //             $('#aviso_cpf').addClass('d-none');
        //         }, 1500);
        //         event.preventDefault(); // Impede a submissão do formulário
        //     }
        //     if (foto1 === '' || foto2 === '') {
        //         $('#aviso_fotos').removeClass('d-none');
        //         setTimeout(() => {
        //             $('#aviso_fotos').addClass('d-none');
        //         }, 1500);
        //         event.preventDefault(); // Impede a submissão do formulário
        //     }

        //     // if (foto1.trim() === '') {
        //     // alert('O campo Foto 1 é obrigatório.');
        //     // event.preventDefault(); // Impede a submissão do formulário
        //     // return; // Interrompe a execução adicional
        //     // }

        //     // if (foto2.trim() === '') {
        //     //     alert('O campo Foto 2 é obrigatório.');
        //     //     event.preventDefault(); // Impede a submissão do formulário
        //     //     return; // Interrompe a execução adicional
        //     // }

        // });

    </script>
@endsection
