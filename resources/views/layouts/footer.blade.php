<footer class="bg-white border-top d-flex align-items-center px-3 fixed-bottom ">
    <img src="{{asset('images/semas-logo.png')}}" width="128" alt="Secretaria de Meio Ambiente e Sustentabilidade">
    <span class="fw-light mx-2 text-body-tertiary mx-auto">DTI/GESIS © 2024 Secretaria de Meio Ambiente e Sustentabilidade.</span>
    <span class="fw-light text-body-tertiary">V
        {{ Illuminate\Support\Facades\DB::table('versao')->find(\DB::table('versao')->max('id'))->versao }}
     </span>
</footer>
