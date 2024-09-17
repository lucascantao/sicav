<div class="bg-white p-1">
    @isset($breadcrumbs)
        <i class="bi bi-{{$breadcrumbs['icon']}}"></i>
        @isset($breadcrumbs['breadcrumbs'])
            @foreach ($breadcrumbs['breadcrumbs'] as $breadcrumb)
                @if (!$loop->last)
                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                    <i class="bi bi-caret-right-fill"></i>
                @else
                    {{ $breadcrumb['title'] }}
                @endif
            @endforeach
        @endisset
    @endisset
</div>
