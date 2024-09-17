@extends('app')
@section('title', 'visitas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'calendar',
        'breadcrumbs' => [
            ['title' => 'Visitas', 'url' => route('visita.index')],
            ['title' => 'Cadastrar', 'url' => route('visita.create')],
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="card border-0 card-body m-4 px-4 py-4">

            @include('components.notification')
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <b><label class="form-label" for="pessoa_id">Nome do Visitante</label></b>
                    <input class="form-control bg-secondary-subtle" type="text" @disabled(true) value="{{ $pessoa_nome }}">
                </div>
                <div class="col-lg-4 col-md-4">
                    <b><label class="form-label" for="documento">Nº Documento</label></b>
                    <input class="form-control bg-secondary-subtle" name="documento" type="text" placeholder="" @disabled(true) value="{{ $pessoa_documento }}">
                </div>
            </div>
            <form method="post" action="{{route('visita.store')}}">
                @csrf
                @method('post')

                <div class="row">
                    <div class="col-4">
                        <input hidden name="pessoa_id" id="pessoa_id" type="text" value="{{ $pessoa_id }}">
                        <div class="row">
                            <b><label class="form-label" for="empresa_id">Empresa</span></label></b>
                            <select class="" name="empresa_id" id="empresa_id">
                                <option value=""></option>
                                @foreach($empresas as $empresa)
                                    @if ($empresa->deleted_at == null )
                                        <option selected hidden></option>
                                        <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <b><label class="form-label" for="unidade_id">Unidade <span style="color: red"> *</span></label></b>
                            <select class="" name="unidade_id" id="unidade_id" required>
                                <option value=""></option>
                                @foreach($unidades as $unidade)
                                    @if ($unidade->deleted_at == null )
                                        <option selected hidden></option>
                                        <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="">
                                <b><label class="form-label" for="motivo">Motivo <span style="color: red"> *</span></label></b>
                                <textarea class="form-control" id="motivo" name="motivo" rows="5" placeholder="" maxlength="250" required></textarea>
                                <div id="charCount" class="character-count">250 caracteres restantes</div>
                            </div>
                            <div class="">
                                <label class="form-label" for="usuario_cadastro_id"> </label>
                                <input class="form-control" name="usuario_cadastro_id" type="text" placeholder="" hidden value="{{ $id_usuario }}">
                            </div>
                        </div>
                    </div>
    
                    <div class="col-4">
                        <livewire:select />
                    </div>
                </div>


                {{-- <div class="row">
                    <input hidden name="pessoa_id" id="pessoa_id" type="text" value="{{ $pessoa_id }}">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="empresa_id">Empresa</span></label></b>
                        <select class="" name="empresa_id" id="empresa_id">
                            <option value=""></option>
                            @foreach($empresas as $empresa)
                                @if ($empresa->deleted_at == null )
                                    <option selected hidden></option>
                                    <option value="{{ $empresa->id }}">{{ $empresa->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="setor_id">Setor <span style="color: red"> *</span></label></b>
                        <select class="" name="setor_id" id="setor_id" required>
                            <option value=""></option>
                            @foreach($setores as $setor)
                            <option selected hidden value=""></option>
                                @if ($setor->deleted_at == null )
                                    <option value="{{ $setor->id }}">{{ $setor->sigla }} - {{ $setor->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                {{-- <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="unidade_id">Unidade <span style="color: red"> *</span></label></b>
                        <select class="" name="unidade_id" id="unidade_id" required>
                            <option value=""></option>
                            @foreach($unidades as $unidade)
                                @if ($unidade->deleted_at == null )
                                    <option selected hidden></option>
                                    <option value="{{ $unidade->id }}">{{ $unidade->nome }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="servidor_id">Servidor <span style="color: red"> *</span></label></b>
                        <div id="select_servidor">
                            <select class="" name='servidor' id='servidor_id' required onchange="selecionarServidor(null, $(this).val())">
                                <option value=""></option>
                                @foreach($servidores as $servidor)
                                    @if ($servidor->status == 'Ativo' )
                                    <option value="{{ $servidor->nome }}" >{{ $servidor->nome }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="motivo">Motivo <span style="color: red"> *</span></label></b>
                        <textarea class="form-control" id="motivo" name="motivo" rows="5" placeholder="" maxlength="250" required></textarea>
                        <div id="charCount" class="character-count">250 caracteres restantes</div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <label class="form-label" for="usuario_cadastro_id"> </label>
                        <input class="form-control" name="usuario_cadastro_id" type="text" placeholder="" hidden value="{{ $id_usuario }}">
                    </div>
                </div> --}}
                <div class="mt-4">
                    <button type="submit" class="col-2 btn btn-semas me-2 bi bi-floppy"> Salvar</button>
                    <a href="{{ route('pessoa.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <script>
         $(document).ready(function () {
            $('#empresa_id').selectize({
                sortField: 'text'
            });
            // var setor_select = $('#setor_id').selectize({
            //     sortField: 'text'
            // });
            $('#unidade_id').selectize({
                sortField: 'text'
            });
            // $('#servidor_id').selectize();

        });

        // var clicado = false;

        // function selecionarServidor(setor_id, servidor_nome) {
        //     if(clicado) {
        //         $('.overlay').removeClass('d-none');
        //         clicado = false
        //     }
        //     $.ajax({
        //         url: '{{ route("visita.servidores") }}',
        //         method: 'post',
        //         data: {
        //             setor_id: setor_id,
        //             servidor_nome: servidor_nome
        //         },
        //         success: function(response) {
        //             if($('#setor_id').val() == ''){
        //                 clicado = true;
        //                 $('#setor_id')[0].selectize.setValue(response.setor_id);
        //             }
        //             $('#select_servidor').empty()
        //             $('#select_servidor').html(response.view)
        //             $('.overlay').addClass('d-none')
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(xhr.responseText);
        //             $('.overlay').addClass('d-none');
        //         }
        //     });
        // }

        // $('#setor_id').on('change' , function() {
        //     if(!clicado){
        //         clicado = true
        //         selecionarServidor($('#setor_id').val(), null)
        //     } else {
        //         clicado = false
        //     }
        // })

        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('motivo');
            const charCount = document.getElementById('charCount');
            const maxChars = 250; // Número máximo de caracteres

            textarea.addEventListener('input', function() {
                const remainingChars = maxChars - textarea.value.length;
                charCount.textContent = `${remainingChars} caracteres restantes`;
            });
        });
    </script>

    <style>
        .disabled-select {
            pointer-events: none;
            background-color: #e9ecef;
        }
    </style>
@endsection
