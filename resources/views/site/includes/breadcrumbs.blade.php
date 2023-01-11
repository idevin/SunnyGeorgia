@if (count($breadcrumbs))
    <div class="p-breadcrumbs">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$loop->last)
                <a class="p-breadcrumbs__item" href="{{ $breadcrumb->url }}">
                    {{ $breadcrumb->title }}
                </a>
            @else
                <span class="p-breadcrumbs__item p-breadcrumbs__item_current">
                    {{ $breadcrumb->title }}
                </span>
            @endif
        @endforeach
    </div>
@endif

