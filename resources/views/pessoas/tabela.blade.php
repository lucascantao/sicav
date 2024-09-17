<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<center><img src="{{asset('images/brasao-pa.png')}}" width="100px"/></center>
<center><h6>GOVERNO DO ESTADO DO PARÁ</h6></center>
<center><h6>SECRETARIA DE MEIO AMBIENTE E SUSTENTABILIDADE</h7></center>
<BR>
<center><h4>RELAÇÃO DE VISITANTES</h4></center>

<table id="portaria_table" class="table table-hover dataTable compact" align="center">
    <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">Tipo Documento</th>
            <th scope="col" class="text-center">Documento</th>
            <th scope="col" class="text-center">Data de Nascimento</th>
            <th scope="col" class="text-center">Celular</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pessoas as $pessoa)
            <tr>
                <td>{{$pessoa->nome}}</td>
                <td>{{$pessoa->tipo_documento}}</td>
                <td class="text-center">{{$pessoa->documento}}</td>
                <td class="text-center">{{$pessoa->data_nascimento_formatada}}</td>
                <td class="text-center">{{$pessoa->telefone1}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="text-align:center;margin-top:100px;">DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</div>

