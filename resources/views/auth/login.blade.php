@extends('guest')
@section('title', 'registros')
@section('authentication')
<div id="authentication_form" class="d-flex flex-column align-items-center bg-white">
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

    <div>
        @if(session()->has('failed'))
            <div class="alert alert-danger" id="failedMessage">
                {{ session('failed') }}
            </div>
        @endif
    </div>


    @if (session()->has('autenticado'))
        @include('auth.includes.register')
    @else
        @include('auth.includes.login')
    @endif
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
</div>
@endsection
