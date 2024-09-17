@extends('app')
@section('title', 'visitas')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'calendar',
        'breadcrumbs' => [
            ['title' => 'Visitas', 'url' => route('visita.index')],
            ['title' => 'Detalhes', 'url' => route('visita.show', ['visita' => $visita->id])]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            {{-- @include('components.notification') --}}
            {{-- <form id="pessoa_formulario" method="post" action="{{route('pessoa.store')}}"> --}}
                {{-- @csrf --}}
                {{-- @method('post') --}}
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome"><b>Nome</b></label><br>
                    <label class="form-label" for="nome">{{$visita->pessoa->nome}}</label>
                </div>
                <div class="col-lg-2 col-md-4">
                    <label class="form-label" for="tipo_documento"><b>Tipo de Documento</b></label><br>
                    <label class="form-label" for="tipo_documento">{{ $visita->pessoa->tipo_documento }}</label>
                </div>
                <div class="col-lg-2 col-md-4">
                    <label class="form-label" for="documento"><b>Documento</b></label><br>
                    <label class="form-label" for="documento">{{$visita->pessoa->documento}}</label>
                </div>
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="telefone1"><b>Telefone</b></label><br>
                    <label class="form-label" for="telefone1">{{$visita->pessoa->telefone1}}</label>
                </div>
            </div>
            <div id="filtro" class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_empresa"><b>Empresa</b></label><br>
                    <label class="form-label" for="nome_empresa">
                        {{ $visita->empresa->nome ?? '' }}
                    </label>
                </div>
                <div class="col-lg-2 col-md-4">
                    <label class="form-label" for="nome_unidade"><b>Unidade</b></label><br>
                    <label class="form-label" for="nome_unidade">{{$visita->unidade->nome}}</label>
                </div>
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_setor"><b>Setor</b></label><br>
                    <label class="form-label" for="nome_setor">{{$visita->setor->nome}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_setor"><b>Motivo</b></label><br>
                    <label class="form-label" for="nome_setor">{{$visita->motivo}}</label>
                </div>
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="data"><b>Data</b></label><br>
                    <label class="form-label" for="data">{{ $visita->created_at->format('d/m/y H:i') }}</label>
                </div>
            </div>
            <div class="mt-4">

                @if (Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 1) {{-- master --}}
                    <a class="col-2 btn btn-semas me-2" href="{{ route('visita.edit', ['visita' => $visita]) }}" title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if(empty($visita->deleted_at))
                            @php
                                $arr = json_encode([
                                    'id' => $visita->id,
                                    'message' => 'Deseja mesmo exluir a visita de ' . $visita->pessoa->nome . ' ?',
                                    'route' => route('visita.destroy', ['id' => $visita->id])
                                ]);
                            @endphp
                            <label onclick="modalDelete({{$arr}})" class="col-2 btn btn-danger bi bi-trash-fill">Deletar</label>
                            @include('components.modal-delete')
                        @else
                            <a class="col-2 btn btn-outline-secondary" href="{{route('visita.enable', ['id' => $visita->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i> Habilitar</span></a>
                        @endif
                    @endif
                @endif
                <a href="{{ route('visita.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Voltar</a>
            </div>
        </div>
    </div>
@endsection
