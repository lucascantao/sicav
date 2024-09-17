<div>
    @if(session()->has('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('failed'))
        <div class="alert alert-danger" id="failedMessage">
            {{ session('failed') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" id="failedMessage">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </div>
    @endif
    <div class="d-none" id="aviso_cpf">
        <div class="alert alert-danger">
            O formato do CPF está invalido.
        </div>
    </div>
    <div class="d-none" id="aviso_fotos">
        <div class="alert alert-danger">
            As fotos são obrigatorias.
        </div>
    </div>
</div>
<!-- Script para sumir mensagem de confirmação -->
<script>
    setTimeout(function() {
        var notificationMessage = document.querySelector('#successMessage, #failedMessage');
        if (notificationMessage) {
            notificationMessage.classList.add('fade-out');
            setTimeout(function() {
                notificationMessage.style.display = 'none';
            }, 2000); // 500ms corresponde à duração da transição CSS
        }
    }, 3000);
</script>
