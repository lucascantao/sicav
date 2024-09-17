<select onchange="selecionarServidor(null, $(this).val())" class="" name='servidor' id='servidor_id' required>
    <option value=""></option>
    @if (isset($servidor_nome))
        <option selected value="{{ $servidor_nome }}" >{{ $servidor_nome }}</option>
    @endif
    @foreach($servidores as $servidor)
        <option data-value="{{ $servidor->setor_id }}" value="{{ $servidor->nome }}" >{{ $servidor->nome }}</option>
    @endforeach
</select>

<script>
    $('#servidor_id').selectize();

</script>
