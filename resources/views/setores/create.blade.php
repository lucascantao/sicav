@extends('app')
@section('title', 'setores')
@section('content')
    @php
        $breadcrumb = [
            'icon' => 'archive-fill',
            'breadcrumbs' => [
                ['title' => 'Setores', 'url' => route('setor.index')],
                ['title' => 'Cadastrar', 'url' => route('setor.create')]
            ]
        ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])

    <div>
        <div class="card border-0 card-body m-4 px-6 py-6">
            @include('components.notification')
            <form method="post" action="{{route('setor.store')}}">
            @csrf
            @method('post')
                <div class="row mb-3">
                    <div class="col-3 mb-3">
                        <b><label for="sigla" class="form-label">Sigla <span style="color: red"> *</span></label></b>
                        <input type="text" name="sigla" maxlength="250" class="form-control" style="text-transform: uppercase;">
                    </div>
                    <div class="col-6 mb-3">
                        <b><label for="nome" class="form-label">Nome <span style="color: red"> *</span></label></b>
                        <input type="text" class="form-control" maxlength="250" name="nome" style="text-transform: uppercase;">
                    </div>
                </div>

                <div>
                    <button type="submit" class="col-2 btn btn-semas bi bi-floppy"> Salvar</button>
                    <a href="{{route('setor.index')}}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>
                </div>
            </form>

        </div>
    </div>
@endsection
