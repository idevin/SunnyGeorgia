<script>
    window.Laravel = {!! json_encode([
        'csrfToken'     => csrf_token(),
        'user'          => Auth::user() ? Auth::user()->load('avatar') : '',
        'locale'        => app()->getLocale(),
        'currency_code' => currency()->getUserCurrency(),
    ]) !!};
</script>
