<span class="mt-2"><a href="/"><img src="{{asset('images/sicav-login-v1.png')}}" height="128px" style="object-fit: fill;" alt=""></a></span>
<form method="POST" action="{{ route('login') }}" class="d-flex flex-column align-items-center justify-content-center auth-form" style="height: 80%">
    @csrf

    <!-- Username -->
    <div class="mt-2 mb-4 w-100 px-4">
        <input id="username" class="mt-1 form-control-lg" style="color: #05296b !important; background-color: transparent !important; border: none; border-bottom: 2px solid #003594" type="text" name="username" placeholder="usuário" autocomplete="username" />
    </div>

    <!-- Password -->
    <div class="mt-2 mb-4 w-100 px-4">
        <input id="password" class="mt-1 form-control-lg" style="color: #05296b !important; background-color: transparent !important; border: none; border-bottom: 2px solid #003594" type="password" name="password" placeholder="senha" required autocomplete="new-password" />
    </div>

    <div class="d-flex align-items-center justify-content-center mt-4 col-12">
        <button id="login_button" type="submit" class="btn btn-semas">
            Entrar
        </button>

    </div><br>
        <span style="font-size: 14px">
            <a id="manual" href="{{asset('images/Manual-SICOP_v1.pdf')}}" style="color: #3E4B67; font-weight: bold;" target="blank">
                Clique aqui
            </a> para acessar o manual do sistema
        </span>
</form>
