@extends('app')
@section('title', 'pessoas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'people-fill',
        'breadcrumbs' =>[
            ['title' => 'Visitantes', 'url' => route('pessoa.index')],
            ['title' => 'Editar', 'url' => route('pessoa.edit', ['pessoa' => $pessoa->id])]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="card border-0 card-body m-4 px-6 py-6">
            @include('components.notification')
            <form method="post" action="{{route('pessoa.update', ['pessoa' => $pessoa])}}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="nome">Nome<span style="color: red"> *</span></label></b>
                        <input class="form-control" name="nome" maxlength="250" type="text" placeholder="" value="{{ $pessoa->nome }}" required>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="tipo_documento">Tipo de Documento<span style="color: red"> *</span></label></b>
                        @if ($pessoa->tipo_documento == "CPF")
                            <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                <option selected >{{ $pessoa->tipo_documento }}</option>
                                <option value="Passaporte">Passaporte</option>
                            </select>
                        @else
                            <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                <option selected >{{ $pessoa->tipo_documento }}</option>
                                <option value="CPF">CPF</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="documento">Documento<span style="color: red"> *</span></label></b>
                        <input id="documento" class="form-control" name="documento" maxlength="250" type="text" placeholder="" value="{{ $pessoa->documento }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="email">E-mail</label></b>
                        <input id="email" class="form-control" name="email" maxlength="250" type="email" placeholder="" value="{{ $pessoa->email }}">
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="sexo">Sexo<span style="color: red"> *</span></label></b>
                        @if ($pessoa->sexo == "Masculino")
                            <select class="form-select" name="sexo" id="sexo" required>
                                <option selected >{{ $pessoa->sexo }}</option>
                                <option value="Feminino">Feminino</option>
                            </select>
                        @else
                            <select class="form-select" name="sexo" id="sexo" required>
                                <option selected >{{ $pessoa->sexo }}</option>
                                <option value="Masculino">Masculino</option>
                            </select>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="data_nascimento">Data de Nascimento<span style="color: red"> *</span></label></b>
                        <input class="form-control" name="data_nascimento" id="data_nascimento" type="date" value="{{ $pessoa->data_nascimento}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="telefone1">Celular<span style="color: red"> *</span></label></b>
                        <input id="telefone1" class="form-control" name="telefone1" type="text" placeholder="(00) 00000-0000" value="{{ $pessoa->telefone1 }}" required>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="telefone2">Telefone</label></b>
                        <input id="telefone2" class="form-control" name="telefone2" type="text" placeholder="(00) 0000-0000" value="{{ $pessoa->telefone2 }}" >
                    </div>
                </div>

                <div id="filtro" class="row">
                    <div class="col-lg-2 col-md-4">
                        <b><label class="form-label" for="foto1">Foto 1<span style="color: red"> *</span></label></b>
                        <div>
                            <a onclick="openModal('foto1', 'preview1')" class="col-lg-12 col-md-12 btn btn-semas bi bi-camera"> Abrir Câmera</a>
                            @include('components.modal-camera')
                        </div>
                        <input hidden id="foto1" class="form-control" name="foto1" type="text" placeholder="" value="{{ $pessoa->foto1 }}" required>
                        <img class="mt-2" width="100%" src="{{ asset($pessoa->foto1) }}" id="preview1" alt="">
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <b><label class="form-label" for="foto2">Foto 2<span style="color: red"> *</span></label></b>
                        <div>
                            <a onclick="openModal('foto2', 'preview2')" class="col-lg-12 col-md-12 btn btn-semas bi bi-camera"> Abrir Câmera</a>
                            @include('components.modal-camera')
                        </div>
                        <input hidden id="foto2" class="form-control" name="foto2" type="text" placeholder="" value="{{ $pessoa->foto2 }}" required>
                        <img class="mt-2" width="100%" src="{{ asset($pessoa->foto2) }}" id="preview2" alt="">
                    </div>

                </div>
                <div class="mt-4">
                    <button type="submit" class="col-2 btn btn-semas bi bi-floppy"> Salvar</button>
                    <a href="{{route('pessoa.index')}}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        var data = $('#date');
        var current_value = data.val();
        var ano = moment(data.val(), 'YYYY-MM-DD').format('YYYY');

        $('#date').on('change', function () {
            if(moment($(this).val(), 'YYYY-MM-DD').format('YYYY') != ano) {
                alert('A data da portaria não pode exceder o ano atual da portaria');
                data.val(current_value);
            }
        });

        $(document).ready(function () {
            $('#assunto_id').selectize({
                sortField: 'text'
            });
        });
        $(document).ready(function() {
            $('#date').attr('min', new Date().toISOString().slice(0, 10));
        });

        $(document).ready(function() {
            $('#Ano').on('keypress', function(event) {
                if (!/[0-9\b]/.test(event.key)) {
                    event.preventDefault();
                }
            });
        });

        // Máscara do telefone
        IMask(document.getElementById('telefone1'), {
            mask: '(00) 00000-0000'
        });

        IMask(document.getElementById('telefone2'), {
            mask: '(00) 0000-0000'
        });

        // Máscara do cpf
        if( $('#tipo_documento').val()=='CPF')
        {
            documento = IMask(document.getElementById('documento'),
            {
                mask: '000.000.000-00'
            });
        }

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
