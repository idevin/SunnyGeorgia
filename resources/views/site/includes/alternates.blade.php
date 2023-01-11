@foreach($alternates as $code => $alternate)
    @if(isset($alternate['noindex']) && $alternate['noindex']) @continue @endif
    <link rel="alternate"
          hreflang="{{ $code }}"
          href="{{ $alternate['url'] }}"
    />
@endforeach
