@extends('app')
@section('title', 'usuarios')
@section('content')

    @php
    $breadcrumb = [
        'icon' => 'people-fill',
        'breadcrumbs' => [
            ['title' => 'Usuarios', 'url' => route('user.index')],
            ['title' => 'Detalhes', 'url' => route('user.show', ['user' => $user->id])]
        ]
    ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="bg-white m-4 px-4 py-4 card">
            @include('components.notification')
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <label class="form-label" for="nome_user"><b>Usuário</b></label><br>
                    <label class="form-label" for="nome_user">{{$user->name}}</label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="nome_user"><b>Status</b></label><br>
                    <label class="form-label" for="nome_user">
                        @if ($user->deleted_at != null)
                        <td class="text-danger text-center">Desabilitado</td>
                        @else
                        <td class="text-success text-center">Habilitado</td>
                        @endif
                    </label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="nome_user"><b>Perfil</b></label><br>
                    @if($user->perfil != null)
                    <label class="form-label" for="nome_user">{{$user->perfil->nome}}</label>
                    @else
                    <label class="form-label" for="nome_user">Sem Perfil</label>
                    @endif
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <label class="form-label" for="nome_user"><b>Setor</b></label><br>
                <label class="form-label" for="nome_user">{{$user->setor->sigla}} - {{$user->setor->nome}}</label>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="user_create"><b>Data de Criação</b></label><br>
                    <label class="form-label" for="user_create">{{ $user->created_at->format('d/m/y H:i:s') }}</label>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="user_up"><b>Ultima Atualização</b></label><br>
                    @if($user->updated_at != null)
                        <label class="form-label" for="user_up">{{$user->updated_at->format('d/m/y H:i:s')}}</label>
                    @endif
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label" for="user_desat"><b>Data de Desativação</b></label><br>
                    @if($user->deleted_at != null)
                        <label class="form-label" for="empresa_desat">{{date_format(date_create_from_format('Y-m-d H:i:s', $user->deleted_at), 'd/m/Y H:i:s')}}</label>
                    @endif
                </div>
            </div>
            <div class="mt-4">

                @if (Auth::user()->perfil_id == 3) {{-- master --}}
                    <a class="col-2 btn btn-semas me-2" href="{{ route('user.edit', ['id' => $user->id]) }}" title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    @if (Auth::user()->perfil_id == 3) {{-- master --}}
                        @if (empty($user->deleted_at))
                            @php
                                $deleteModalArr = json_encode([
                                    'id' => $user->id,
                                    'message' => 'Deseja mesmo excluir a usuário ' . $user->nome . ' ?',
                                    'route' => route('user.destroy', ['id' => $user->id])
                                ]);
                            @endphp
                            <label onclick='modalDelete({{$deleteModalArr}})' class="col-2 btn btn-danger me-2"><span><i class="bi bi-trash-fill"></i> Deletar</span></label>
                            @include('components.modal-delete')
                        @else
                            <a class="col-2 btn btn-outline-secondary me-1" href="{{route('user.enable', ['id' => $user->id, ''])}}"><span><i class="bi bi-arrow-counterclockwise"></i> Habilitar</span></a>
                        @endif
                    @endif
                @endif
                <a href="{{ route('user.index') }}" id="button_clear" class="col-2 btn btn-outline-secondary"><i class="bi bi-arrow-counterclockwise"></i> Voltar</a>
            </div>
        </div>
    </div>
@endsection
