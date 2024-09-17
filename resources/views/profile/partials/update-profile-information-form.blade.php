<section>
    @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="alert alert-success mb-2"
                >Perfil Atualizado com sucesso.</p>
    @endif
    <header>
        <h2 class="">
            Informações do Perfil
        </h2>

        <p class="">
            Atualize as informações de perfil da sua conta e endereço de email
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6">
        @csrf
        @method('patch')

        <div>
            <label for="name">Nome</label>
            <input id="name" name="name" type="text" class="form-control mb-2" value="{{$user->name}}" required autofocus autocomplete="name" />
        </div>

        <div>
            <label for="email">Email</label>
            <input id="email" name="email" type="email" class="form-control mb-2" value="{{$user->email}}" required autocomplete="username" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button type="submit" class="col-2 btn btn-primary">Atualizar Perfil</button>
        </div>
    </form>
</section>
