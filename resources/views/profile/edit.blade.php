@extends('app')
@section('title', 'registros')
@section('content')
<div>

    <div class="py-12">
        <div class="">
            <div class="p-4 bg-white border-bottom">
                <div class="">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection