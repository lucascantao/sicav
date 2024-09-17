@extends('app')
@section('title', 'empresas')
@section('content')

    @php
    $breadcrumb = [
                'icon' => 'building-fill',
                'breadcrumbs' => [
                    ['title' => 'Empresas', 'url' => route('empresa.index')],
                    ['title' => 'Detalhes', 'url' => route('empresa.show', ['empresa' => $empresa->id])]
                ]
            ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_empresa"><b>Empresa</b></label><br>
                    <label class="form-label" for="nome_empresa">{{$empresa->nome}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="nome_empresa"><b>CNPJ</b></label><br>
                    <label class="form-label" for="nome_empresa">{{$empresa->cnpj}}</label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="nome_empresa"><b>Telefone</b></label><br>
                    <label class="form-label" for="nome_empresa">{{$empresa->tel_contato}}</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="empresa_create"><b>Data de Criação</b></label><br>
                    <label class="form-label" for="empresa_create">{{ $empresa->created_at->format('d/m/y H:i:s') }}</label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="empresa_up"><b>Ultima Atualização</b></label><br>
                    @if($empresa->updated_at != null)
                        <label class="form-label" for="empresa_up">{{$empresa->updated_at->format('d/m/y H:i:s')}}</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="empresa_desat"><b>Data de Desativação</b></label><br>
                    @if($empresa->deleted_at != null)
                        <label class="form-label" for="empresa_desat">{{date_format(date_create_from_format('Y-m-d H:i:s', $empresa->deleted_at), 'd/m/Y H:i:s')}}</label>
                    @endif
                </div>
            </div>
            <div class="mt-4">

                @if (Auth::user()->perfil_id == 3) {{-- master --}}
                    <a class="col-2 btn btn-semas me-2" href="{{ route('empresa.edit', ['empresa' => $empresa]) }}" title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($empresa->deleted_at))
                            @php
                                $deleteModalArr = json_encode([
                                    'id' => $empresa->id,
                                    'message' => 'Deseja mesmo excluir a empresa ' . $empresa->nome . ' ?',
                                    'route' => route('empresa.destroy', ['id' => $empresa->id])
                                ]);
                            @endphp
                            <label onclick='modalDelete({{$deleteModalArr}})' class="col-2 btn btn-danger me-2"><span><i class="bi bi-trash-fill"></i> Deletar</span></label>
                            @include('components.modal-delete')
                        @else
                            <a class="btn btn-opaque-semas me-1" href="{{route('empresa.enable', ['id' => $empresa->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i></span></a>
                        @endif
                    @endif
                @endif
                <a href="{{ route('empresa.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Voltar</a>
            </div>
        </div>
    </div>
@endsection
