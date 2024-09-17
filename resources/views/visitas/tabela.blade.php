<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<center><img src="{{asset('images/brasao-pa.png')}}" width="100px"/></center>
<center><h6>GOVERNO DO ESTADO DO PARÁ</h6></center>
<center><h6>SECRETARIA DE MEIO AMBIENTE E SUSTENTABILIDADE</h7></center>
<BR>
<center><h4>RELAÇÃO DE VISITAS</h4></center>

<table id="portaria_table" class="table table-hover dataTable compact" align="center">
    <thead>
        <tr>
            <th scope="col">Visitante</th>
            <th scope="col">Documento </th>
            <th scope="col" class="text-center">Data</th>
            <th scope="col" class="text-center">Setor</th>
            <th scope="col" class="text-center">Servidor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($visitas as $visita)
            <tr>
                <td>{{$visita->nome}}</td>
                <td>{{$visita->documento}}</td>
                <td class="text-center">{{$visita->created_at_formatada}}</td>
                <td class="text-center">{{$visita->sigla}}</td>
                <td class="text-center">{{$visita->servidor}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div style="text-align:center;margin-top:100px;">DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</div>

