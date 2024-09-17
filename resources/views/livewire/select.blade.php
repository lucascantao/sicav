<div>
    <b><label class="form-label" for="setor_id">Setor <span style="color: red"> *</span></label></b>
    {{-- <input id="lw_setor_id" type="text" wire:model="setor_selecionado"> --}}
    <div>
        <select wire:model.change="setor_id" wire:change="updateServidores" class="form-select" name="setor_id" id="setor_id" required>
            <option selected hidden value="">Selecionar</option>
            {{-- <option value=""></option> --}}
            @foreach($setores as $setor)
                @if ($setor->deleted_at == null )
                    <option value="{{ $setor->id }}">{{ $setor->sigla }} - {{ $setor->nome }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div>
        <b><label class="form-label" for="servidor_id">Servidor <span style="color: red"> *</span></label></b>
        {{-- <input type="text" wire:model.change="servidor_selecionado"> --}}
        <div id="select_servidor">
            <select class="form-select" name='servidor' id='servidor_id' required>
                <option hidden value="">Selecionar</option>
                @foreach($servidores as $servidor)
                    @if ($servidor->status == 'Ativo' )
                    <option value="{{ $servidor->nome }}" >{{ $servidor->nome }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    {{ $setor_id }}
</div>

<script>

    // document.addEventListener('livewire:load', () => {

    //     function initSelects() {
    //         $('#setor_id').selectize(); 
    //         $('#servidor_id').selectize();


    //         $('#setor_id').on('change', () => {
    //             // $('#lw_setor_id').val($('#setor_id')[0].selectize.getValue());
    //             $wire.setor_selecionado = $('#setor_id')[0].selectize.getValue();
    //             $wire.updateServidores();
    //             // $wire.$refresh();
    //             // $('#setor_id').selectize(); 
    //             // $('#servidor_id').selectize();
    //         })

    //     }

    //     initSelects();

    //     Livewire.hook('message.processed', (message, component) => {
    //         initSelects();
    //     });

    // })

    
    
    

</script>


