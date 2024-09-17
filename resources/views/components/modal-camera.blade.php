<!-- Modal -->
<div id="myModal" class="modal" style="padding-top: 5%;">
    <div class="modal-content">
        {{-- <span class="close" onclick="closeModal()">Fechar</span> --}}
        <div class="row col-md-12">
        <span style="text-align:right" class="close" onclick="closeModal()">X</span>  
        </div>    
        <div class="row">
            
                <div class="col-md-6">
                    <h4 style="text-align:center">Visualização da Câmera</h4>
                <!-- Exibição da webcam -->
                    <div>
                        <div id="load_camera" class="overlay d-none">
                            <div style="scale: 3; color: #05296b" class="spinner-border" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                        <div id="camera" class="square"></div>
                    </div>
                <!-- Preview da imagem capturada -->
                </div>
                <div class="col-md-6">
                    <h4 style="text-align:center">Pré-visualização da Foto</h4>
                    <div id="preview" class="square"></div>
                </div>
        </div>
        <div class="row py-3 d-flex col-12" style="text-align: center">            
            <div class="py-2">
                <!-- Botão para capturar imagem -->
                <button type="button" onclick="take_snapshot()" class="col-2 btn btn-semas py-2">Capturar Imagem</button>
                <!-- Botão para Guardar a Captura da imagem, deve ser um <a> para não dar conflito com o Submit do Salvar -->
                <a type="button" style="visibility: hidden; opacity: 0;" id="salvar_captura" class="col-2 btn btn-outline-secondary py-2" onclick="closeModal()">Salvar Captura</a>
            </div>
        </div>
    </div>
</div>

{{-- <div class="overlay d-none">
    <div style="scale: 3; color: #05296b" class="spinner-border" role="status">
        <span class="sr-only"></span>
    </div>
</div>
<script>
    $('form').on('submit', function() {
        $('.overlay').removeClass('d-none');
        setTimeout(() => {
            $('.overlay').addClass('d-none');
        }, 8000);
    });
</script> --}}

<!-- Importe a biblioteca do WebcamJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

<script>
    let currentField = '';
    let currentPreview = '';

    // Função para abrir o modal e iniciar a câmera
    function openModal(field, preview) {
        currentField = field;
        currentPreview = preview;
        document.getElementById('myModal').style.display = "block";
        Webcam.attach('#camera'); // Inicia a captura da webcam
    }

    // Função para fechar o modal e parar a câmera
    function closeModal() {
        document.getElementById('myModal').style.display = "none";
        Webcam.reset(); // Para a captura da webcam
        document.getElementById('preview').innerHTML = '';
        document.getElementById('salvar_captura').style.visibility = 'hidden';
        document.getElementById('salvar_captura').style.opacity = '0';
    }

    Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 100
        });

    // Função para capturar e mostrar preview da imagem
    function take_snapshot() {
        Webcam.snap(function(data_uri) {
            const img = document.createElement('img');
            img.src = data_uri;
            img.style.width = '100%';
            document.getElementById('preview').innerHTML = '';
            document.getElementById('preview').appendChild(img);

            // Define o valor do input e a imagem de pré-visualização
            document.getElementById(currentField).value = data_uri;
            document.getElementById(currentPreview).src = data_uri;
            document.getElementById('salvar_captura').style.visibility = 'visible';
            document.getElementById('salvar_captura').style.opacity = '1';

        });
    }

    Webcam.on( 'load', function() {
    // library is loaded
        $('#load_camera').removeClass('d-none');
            setTimeout(() => {
                $('#load_camera').addClass('d-none');
            }, 8000);
    } );

    Webcam.on( 'live', function() {
        // camera is live, showing preview image
        $('#load_camera').removeClass('d-none');
            setTimeout(() => {
                $('#load_camera').addClass('d-none');
            }, 8000);
    } );

    Webcam.on( 'error', function(err) {
        // an error occurred (see 'err')
    } );

</script>

<!-- jQuery e Bootstrap JS (coloque no final do body para melhor performance) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
