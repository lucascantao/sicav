@extends('app')
@section('title', 'setores')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'archive-fill',
        'breadcrumbs' => [
            ['title' => 'Setores', 'url' => route('setor.index')],
            ['title' => 'Detalhes', 'url' => route('setor.show', ['setor' => $setor['id']])]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            <div class="row">

                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="sigla"><b>Sigla</b></label><br>
                    <label class="form-label" for="sigla">{{$setor->sigla}}</label>
                </div>
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_setor"><b>Setor</b></label><br>
                    <label class="form-label" for="nome_setor">{{$setor->nome}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="setor_create"><b>Data de Criação</b></label><br>
                    <label class="form-label" for="setor_create">{{ $setor->created_at->format('d/m/y H:i:s') }}</label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="setor_up"><b>Ultima Atualização</b></label><br>
                    @if($setor->updated_at != null)
                        <label class="form-label" for="setor_up">{{$setor->updated_at->format('d/m/y H:i:s')}}</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="setor_desat"><b>Data de Desativação</b></label><br>
                    @if($setor->deleted_at != null)
                        <label class="form-label" for="empresa_desat">{{date_format(date_create_from_format('Y-m-d H:i:s', $setor->deleted_at), 'd/m/Y H:i:s')}}</label>
                    @endif
                </div>
            </div>
            <div class="mt-4">
                @if (Auth::user()->perfil_id == 3) {{-- master --}}
                    <a class="col-2 btn btn-semas me-2" href="{{ route('setor.edit', ['setor' => $setor]) }}" title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($setor->deleted_at))
                            @php
                                $deleteModalArr = json_encode([
                                    'id' => $setor->id,
                                    'message' => 'Deseja mesmo excluir a setor ' . $setor->nome . ' ?',
                                    'route' => route('setor.destroy', ['id' => $setor->id])
                                ]);
                            @endphp
                            <label onclick='modalDelete({{$deleteModalArr}})' class="col-2 btn btn-danger me-2"><span><i class="bi bi-trash-fill"></i> Deletar</span></label>
                            @include('components.modal-delete')
                        @else
                            <a class="col-2 btn btn-outline-secondary me-1" href="{{route('setor.enable', ['id' => $setor->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i> Habilitar</span></a>
                        @endif
                    @endif
                @endif
                <a href="{{ route('setor.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Voltar</a>
            </div>
        </div>
    </div>
@endsection
