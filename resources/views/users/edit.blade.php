@extends('app')
@section('title', 'usuarios')
@section('content')

    @php
        $breadcrumb = [
            'icon' => 'people-fill',
            'breadcrumbs' => [
                ['title' => 'Usuarios', 'url' => route('user.index')],
                ['title' => 'Editar', 'url' => route('user.edit', ['id' => $user->id])]
            ]
        ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

<div class="card border-0 card-body m-4 px-6 py-6">
    <form action="{{route('user.update', ['id' => $user->id])}}" method="POST">
        @csrf
        @method('put')
        <div class="row row-cos-6">
            <div class="col-6">
                <b><label for="usuario_nome" class="form-label">Nome<span style="color: red"> *</span></label></b>
                <input id="usuario_nome" type="text" maxlength="250" name="name" class="form-control" value="{{$user->name}}">
            </div>

            <div class="col-6">
                <b><label for="usuario_nome" class="form-label">Setor<span style="color: red"> *</span></label></b>
                <select id="usuario_setor" class="form-select" name="setor_id">
                    <option selected hidden>Selecionar Setor</option>
                    @foreach ($setores as $setor)
                    @if ($setor->id == $user->setor->id)
                        <option selected name="{{$setor->sigla}}" value="{{$setor->id}}" id="">{{$setor->sigla}} - {{$setor->nome}}</option>
                    @else
                        <option name="{{$setor->sigla}}" value="{{$setor->id}}" id="">{{$setor->sigla}}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-6">
                <b><label for="usuario_perfil" class="form-label">Perfil</label></b>
                @if (Auth::user()->perfil_id == 3) {{-- master --}}
                    <select id="usuario_perfil" class="form-select" name="perfil_id">
                        <option selected hidden value="null">Selecionar pefil</option>
                        @foreach ($perfis as $perfil)
                            @if ($perfil->id == $user->perfil_id)
                                <option selected name="{{$perfil->nome}}" value="{{$perfil->id}}" id="">{{$perfil->nome}}</option>
                            @else
                                <option name="{{$perfil->nome}}" value="{{$perfil->id}}" id="">{{$perfil->nome}}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                <select disabled="true" id="usuario_perfil" class="form-select" name="perfil_id">
                    <option selected hidden value="null">Selecionar pefil</option>
                    @foreach ($perfis as $perfil)
                        @if ($perfil->id == $user->perfil_id)
                            <option selected name="{{$perfil->nome}}" value="{{$perfil->id}}" id="">{{$perfil->nome}}</option>
                        @else
                            <option name="{{$perfil->nome}}" value="{{$perfil->id}}" id="">{{$perfil->nome}}</option>
                        @endif
                    @endforeach
                </select>
                @endif
            </div>

        </div>
        <div class="d-flex mt-4">
            <button class="col-2 btn btn-semas me-1 bi bi-floppy" type="submit"> Salvar usuário</button>
            <a href="{{route('user.index')}}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>
            @if($user->deleted_at == null)
                @php
                    $deleteModalArr = json_encode([
                        'id' => $user->id,
                        'message' => 'Deseja mesmo excluir a usuário ' . $user->nome . ' ?',
                        'route' => route('user.destroy', ['id' => $user->id])
                    ]);
                @endphp
                <label onclick='modalDelete({{$deleteModalArr}})' class="col-2 btn btn-danger ms-1"><span><i class="bi bi-trash-fill"></i> Deletar</span></label>
                @include('components.modal-delete')
            @else
                <a href="{{route('user.enable', ['id' => $user->id])}}" class="col-2 btn btn-opaque-semas ms-1">Habilitar Usuário</a>
            @endif
        </div>
    </form>

</div>

<script>

</script>
@endsection
