@extends('app')
@section('title', 'unidades')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'buildings-fill',
        'breadcrumbs' => [
            ['title' => 'Unidades', 'url' => route('unidade.index')],
            ['title' => 'Detalhes', 'url' => route('unidade.show', ['unidade' => $unidade->id])],
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_unidade"><b>Unidade</b></label><br>
                    <label class="form-label" for="nome_unidade">{{$unidade->nome}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="unidade_create"><b>Data de Criação</b></label><br>
                    <label class="form-label" for="unidade_create">{{ $unidade->created_at->format('d/m/y H:i:s') }}</label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="unidade_up"><b>Ultima Atualização</b></label><br>
                    @if($unidade->updated_at != null)
                        <label class="form-label" for="unidade_up">{{$unidade->updated_at->format('d/m/y H:i:s')}}</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="unidade_desat"><b>Data de Desativação</b></label><br>
                    @if($unidade->deleted_at != null)
                        <label class="form-label" for="empresa_desat">{{date_format(date_create_from_format('Y-m-d H:i:s', $unidade->deleted_at), 'd/m/Y H:i:s')}}</label>
                    @endif
                </div>
            </div>
            <div class="mt-4">

                @if (Auth::user()->perfil_id == 3) {{-- master --}}
                    <a class="col-2 btn btn-semas me-2" href="{{ route('unidade.edit', ['unidade' => $unidade]) }}" title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($unidade->deleted_at))
                            @php
                                $deleteModalArr = json_encode([
                                    'id' => $unidade->id,
                                    'message' => 'Deseja mesmo excluir a unidade ' . $unidade->nome . ' ?',
                                    'route' => route('unidade.destroy', ['id' => $unidade->id])
                                ]);
                            @endphp
                            <label onclick='modalDelete({{$deleteModalArr}})' class="col-2 btn btn-danger me-2"><span><i class="bi bi-trash-fill"></i> Deletar</span></label>
                            @include('components.modal-delete')
                        @else
                            <a class="col-2 btn btn-outline-secondary me-1" href="{{route('unidade.enable', ['id' => $unidade->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i> Habilitar</span></a>
                        @endif
                    @endif
                @endif
                <a href="{{ route('unidade.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Voltar</a>
            </div>
        </div>
    </div>
@endsection
