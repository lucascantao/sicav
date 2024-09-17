@extends('app')
@section('title', 'visitas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'calendar',
        'breadcrumbs' => [
            ['title' => 'Visitas', 'url' => route('visita.index')],
            ['title' => 'Editar', 'url' => route('visita.edit', ['visita' => $visita->id])]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="card border-0 card-body m-4 px-6 py-6">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{route('visita.update', ['visita' => $visita])}}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="nome">Nome</label></b>
                        <input class="form-control bg-secondary-subtle" name="nome" placeholder="" @disabled(true) value="{{ $visita->pessoa->nome }}"></input>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <b><label class="form-label" for="tipo_documento">Tipo de Documento</label></b>
                        <input class="form-control" name="tipo_documento" placeholder="" @disabled(true) value="{{ $visita->pessoa->tipo_documento }}" ></input>
                    </div>
                    <div class="col-lg-2 col-md-4">
                        <b><label class="form-label" for="documento">Documento</label></b>
                        <input class="form-control" name="documento" placeholder="" @disabled(true) value="{{ $visita->pessoa->documento }}" ></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="empresa_id">Empresa</label></b>
                        <select class="" name="empresa_id" id="empresa_id" >
                            <option value=""></option>
                            @foreach($empresas as $empresa)
                                <option value="{{ $empresa->id }}" {{ $visita->empresa_id == $empresa->id ? 'selected' : '' }}>
                                    {{ $empresa->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="setor_id">Setor <span style="color: red"> *</span></label></b>
                        <select class="" name="setor_id" id="setor_id" required>
                            <option value=""></option>
                            @foreach($setores as $setor)
                                <option value="{{ $setor->id }}" {{ $visita->setor_id == $setor->id ? 'selected' : '' }}>
                                    {{ $setor->sigla }} - {{ $setor->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="unidade_id">Unidade <span style="color: red"> *</span></label></b>
                        <select class="" name="unidade_id" id="unidade_id" required>
                            <option value=""></option>
                            @foreach($unidades as $unidade)
                                <option value="{{ $unidade->id }}" {{ $visita->unidade_id == $unidade->id ? 'selected' : '' }}>
                                    {{ $unidade->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="servidor_id">Servidor <span style="color: red"> *</span></label></b>
                        <select class="" name='servidor' id='servidor_id' required>
                            @foreach($servidores as $servidor)
                                @if ($servidor->status == 'Ativo' )
                                @if($servidor->nome == $visita->servidor)
                                    <option selected value="{{ $visita->servidor}}" >{{$visita->servidor}}</option>
                                @else
                                    <option value="{{ $servidor->nome }}" >{{ $servidor->nome }}</option>
                                @endif
                                @endif
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="motivo">Motivo <span style="color: red"> *</span></label></b>
                        <textarea class="form-control" id="motivo" name="motivo" rows="5" maxlength="250" placeholder="" value="{{ $visita->motivo}}" required>{{ $visita->motivo}}</textarea>
                        <div id="charCount" class="character-count">250 caracteres restantes</div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <b><label class="form-label" for="created_at">Data</label></b>
                        <input class="form-control" name="created_at" type="text" placeholder="" @disabled(true) value="{{date_format(date_create_from_format('Y-m-d H:i:s', $visita->created_at), 'd/m/Y H:i:s')}}" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="col-2 btn btn-semas bi bi-floppy"> Salvar</button>
                    @if(empty($visita->deleted_at))
                        @php
                            $arr = json_encode([
                                'id' => $visita->id,
                                'message' => 'Deseja mesmo exluir a visita de ' . $visita->pessoa->nome . ' ?',
                                'route' => route('visita.destroy', ['id' => $visita->id])
                            ]);
                        @endphp
                        <label onclick="modalDelete({{$arr}})" class="col-2 btn btn-danger bi bi-trash-fill">Deletar</label>
                    @else
                        <a class="col-2 btn btn-outline-secondary" href="{{route('visita.enable', ['id' => $visita->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i> Habilitar</span></a>
                    @endif
                    <a href="{{route('visita.index')}}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>
                </div>
            </form>
            @include('components.modal-delete')
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#empresa_id').selectize({
                sortField: 'text'
            });
            $('#setor_id').selectize({
                sortField: 'text'
            });
            $('#unidade_id').selectize({
                sortField: 'text'
            });
            $('#servidor_id').selectize({
                sortField: 'text'
            });
        });

        // document.addEventListener('DOMContentLoaded', function() {
        //     const textarea = document.getElementById('motivo');
        //     const charCount = document.getElementById('charCount');
        //     const maxChars = 250; // Número máximo de caracteres

        //     textarea.addEventListener('input', function() {
        //         const remainingChars = maxChars - textarea.value.length;
        //         charCount.textContent = `${remainingChars} caracteres restantes`;
        //     });
        // });
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('motivo');
            const charCount = document.getElementById('charCount');
            const maxChars = 250; // Número máximo de caracteres

            // Função para atualizar a contagem de caracteres restantes
            function updateCharCount() {
                const remainingChars = maxChars - textarea.value.length;
                charCount.textContent = `${remainingChars} caracteres restantes`;
            }

            // Atualizar a contagem ao carregar a página
            updateCharCount();

            // Atualizar a contagem ao digitar no textarea
            textarea.addEventListener('input', updateCharCount);
        });
    </script>
@endsection
