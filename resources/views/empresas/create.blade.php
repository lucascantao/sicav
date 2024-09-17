@extends('app')
@section('title', 'empresas')
@section('content')

    @php
        $breadcrumb = [
                    'icon' => 'building-fill',
                    'breadcrumbs' => [
                        ['title' => 'Empresas', 'url' => route('empresa.index')],
                        ['title' => 'Cadastrar', 'url' => route('empresa.create')]
                    ]
                ];
    @endphp

    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumb])
    <div>
        <div class="card border-0 card-body m-4 px-6 py-6">
            @include('components.notification')

            <form method="post" action="{{route('empresa.store')}}">
            @csrf
            @method('post')
                <div class="row mb-3">
                    <div class="col-12 mb-3">
                        <b><label for="nome" class="form-label">Nome <span style="color: red"> *</span></label></b>
                        <input type="text" value="{{old('nome')}}" class="form-control" name="nome" maxlength="250" style="text-transform: uppercase;" required>
                    </div>
                    <div class="col-6 mb-3">
                        <b><label for="nome" class="form-label">CNPJ </label></b>
                        <input id="cnpj" type="text" value="{{old('cnpj')}}" class="form-control" name="cnpj" style="text-transform: uppercase;" placeholder="00.000.000/0000-00">
                    </div>
                    <div class="col-6 mb-3">
                        <b><label for="nome" class="form-label">Telefone de contato </label></b>
                        <input id="tel_contato" type="text" value="{{old('tel_contato')}}" class="form-control" name="tel_contato" style="text-transform: uppercase;" placeholder="(00) 00000-0000">
                    </div>
                </div>

                <div>
                    <button type="submit" class="col-2 btn btn-semas bi bi-floppy"> Salvar</button>
                    <a href="{{route('empresa.index')}}" id="button_clear" class="col-2 btn btn-outline-secondary bi bi-x-circle"> Cancelar</a>
                </div>
            </form>

        </div>
    </div>
    <script>
        // Máscara do telefone
        const tel_contato = IMask(document.getElementById('tel_contato'), {
            mask: '(00) 00000-0000'
        });

        // Máscara do cnpj
        const cnpj = IMask(document.getElementById('cnpj'), {
            mask: '00.000.000/0000-00'
        });
    </script>
@endsection
