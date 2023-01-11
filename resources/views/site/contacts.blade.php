@extends('site.layouts.new-app')

@push('header')
    <title>{{ $meta['title'] ?? 'Контакты' }}</title>
    <meta property="og:title" content="{{$meta['title'] ?? 'Контакты'}}" />
    <meta property="og:description" content="{{$meta['description'] ?? ''}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{route('contacts')}}" />

    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    {{--  @foreach ($cssChunks as $filename)--}}
    {{--    <link rel="preload" href="{{ URL::asset($filename) }}" as="style">--}}
    {{--  @endforeach--}}
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">

    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush

@section('content')
    <div class="page-wrapper">
        <main class="page-main">
            <div class="search-block-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            {{ Breadcrumbs::view('breadcrumbs::json-ld', Request::route()->name) }}
                            {{ Breadcrumbs::render(Request::route()->name) }}
                        </div>
                    </div>
                </div>
            </div>

            <contacts-page inline-template>
                <div>
                    <div class="map-block">
                        <google-map></google-map>
                   </div>
                    <div class="container">
                        <div class="contacts">
                            <div class="contacts__left">
                                <div class="contacts__title">
                                    <div class="contacts__title-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="58"
                                             height="38" viewBox="0 0 58 38">
                                            <image id="e-mail-envelope" width="58" height="38"
                                                   xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAADoAAAAmCAYAAACVr4jIAAADX0lEQVRogd2ZTUhUURiGn0lRSSh/CmxRaEShFFQILiwIQog2ghCBC8GCoE0thBJcuIhAqFUQVFAgRAtxI7QQhCBK3IQgSKSCmfgTJeqYpYU/ceq7cvycOzP3zp0f54UDM/ee837vg54559wbAr4A+8luhXMFMttByXW5vgr8TnGWoJQPFETyWgQ2VTP/zlW7ELJKsmsew7gN9If1OQxcTH/2uGWyhl1YdoCeAaat73+A5l0A2SxZndzTwuIKanQYGFJ/+ntAKL0sERWSbHbWIWEgFqjRPqBXGbwE8jKD75/yJJOdsVeyO4oJivwiP1NGb4HilCPtVLFksbOZrHoViQvUUasy/ARUpJ5tSxWSwc7U6tLXE6jRVVlbnX7fgJrksbiqRmo7OVYlm5s8gxqdA+asvr+AhhRCNkhNp/6cZIomX6BGx4Exq/8G0JJUvP9qkVpO3THJEku+QY0OAP1qjjwGcpIAmCPedq1+yRCPEgJF9pJdKsBroDBAyELxtGt0ue1jXZQwKLJYd6ggg8ChRAnFY1B5d/jYtAQC6ugGsGZ5TAInfXohYyctvzWp4UeBghpdApbUgaDOh08d2zfmS+LtV4GDGp0GptSB4LqH8dfUxnxKPBNRUkDNaWFGzSvT7seYWyHpo8fNiGdGgV4GltX6aod+5XIgyJN7my5jl8XbrwIFvQmsWx4TwCngqQJ4B5RY40rkmt3niYydsK6tSw0/CgR0D/BQBf0AlFl97qr7I8BRaSPq3h1rXJl42fcfpGN52Qt0qyA9cl3rCrBi9fsuzfm+In0i1ehRNbpdaiQF9CAwoAI8irEFrFVwNnRtlHE54m2PGZAMSQU9AYyr+XMrzqLHgFFr7Khci0e31e/AuGRJCuh5YN7qa45M9XEGdVQKvJdW6nFsvTqmzUumaPIM2qgW869AtcegjvKl+VG11LY3JY1BgbapOfIRKPcZNAiVSwY7U1sioGYxf6EM3wBFaYR0VCRZ7GzPI2xKYoKal059yqgzAx93dqqMfeqFWVTQI8CwMmjP4AfY7SrrsDAQDfQsMKsme1N6WeJSk/qxnBUWV9Cf1ucF4ELmM27JZF1wYdkB6rTPQGVm5PekSsmueRZDAqrfeGfbi+Cw2xvvAo9P2zJeBtQ8o8luQfgvdfwJtx54mycAAAAASUVORK5CYII="/>
                                        </svg>
                                    </div>
                                    <div class="contacts__title-label">{{trans('contacts.Send us a message')}}</div>
                                </div>
                                <div class="contacts__content">
                                    <form action="{{route('contacts')}}">
                                        {!! csrf_field() !!}
                                        <input type="text"
                                               placeholder="{{trans('contacts.Your name')}}"
                                               class="contacts__content-input"
                                               name="name"
                                        >
                                        <div class="contacts__content-input-wrap">
                                            <input type="text"
                                                   placeholder="{{trans('contacts.Email')}}"
                                                   class="contacts__content-input"
                                                   required
                                                   name="email"
                                            >
                                            <input type="text"
                                                   placeholder="{{trans('contacts.Mobile')}}"
                                                   class="contacts__content-input"
                                                   name="phone"
                                            >
                                        </div>
                                        <textarea name="message"
                                                  id=""
                                                  cols="30"
                                                  rows="3"
                                                  placeholder="{{trans('contacts.Your message')}}"
                                                  class="contacts__content-input"
                                                  maxlength="1000"
                                                  required
                                        ></textarea>
                                        <div class="contacts__content-input-wrap">
                                            <div class="contacts__content-select">
                                                <div class="contacts__content-select-label">{{trans('contacts.Contact us')}}</div>
                                                <select name="contact-type" class="contacts__content-select-block">
                                                    <option value="email">{{trans('contacts.By email')}}</option>
                                                    <option value="phone">{{trans('contacts.By phone')}}</option>
                                                </select>
                                            </div>
                                            <button type="submit"
                                                    class="contacts__content-submit"
                                            >{{trans('contacts.Submit')}}</button>
                                        </div>
                                        <div class="contacts__content-personal">
                                                <span class="filter-text">{{trans('contacts.Personal data')}}</span>
                                            <a href="{{route('legal-information')}}" class="checkbox-row-more">Подробнее</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="contacts__right">
                                <div class="contacts__title">
                                    <div class="contacts__title-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="43"
                                             height="43" viewBox="0 0 43 43">
                                            <image id="phone-call_1_" data-name="phone-call (1)" width="43" height="43"
                                                   xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACsAAAArCAYAAADhXXHAAAAERklEQVRYhcWYaYiWVRTHf+8kb5JaObYoLmA6+iEIs2gxSRwwCVLRsUQUWkBUkiCT0g/R10IDFVLUyLVFwjFcyiCz+jSKlFRmWY4VGUY4mpbmiAsHzpXD9d5ne593/MPDC/ece+7/PXc5yw3UD03A58DTwD1AN+AP4EId1yyMOcBl7/sXWAc8UMRokmdvBp4AHlWvHMtp+yedJ98dulYVGAHMAsYAB4E/a/XKdOCk5xXZ0jsL2usJTAFagU5j8xKwWh1TCHMD2+e+X4ABNTpiELDcI90OjMxryBL9B3gGGAJsLJmwYBiwx9g9B0wtSvRBI6sAK+tAuAFYCFxUuxf19UjEFD0/IaJFCVdUXslA+nHgrCEc9XAfoEMVz0SIFiG8SnX+Bj4EJqgnY3jEEJYjcV9I7xWz+FMZvOATPgB0D+h9FLigcpGmJdgeb47E0dArsVuFhzMQtYTXGBIvBHR6A7OBD3THLOktwC0R2y8bvdW+sF0F7+Ugiz7wv+ncj1N0xUPz9T44It9FjlDFeyXut8JfdXB9TrINGqVk7qcZ5/QzO+kI3xrQazLv8B4r+Cbngg6LzaKLcsyTHXnXzG2N6C0zOlcv/WYdyBOjX/cuTa8ccx1h6+HpAZ2Bxrsb3OACM2lYyiJynt4w+pLyDc1J1KGfOcNHI8/aFpX/B9yEZkFu8YUpCywpiajDS8bepIB8spFPdINHdOBQQsRpNFGuDKLoK+Geta0BeQ/gvMqXu8FF5h88FjFc1eRZdPZlDKNZ4O5MR+QotKm8zQ3cDvyvgzsSFngzZ7TLgtnG5sCAvrsjB+zgWjMpVnbInzqlOn/VkIxb9NbQvCKyW3KxngPusoNDtZgTIl8kGJ9l/tSuEo9DbryVcjtRctuN3pLrRbYvcFpJHIuEQvRl+DklkekSPG9IrEtYsElzVac793qQ9bOelgTdUSZhlm9eBvv9Ne7v1bvxInBjLYQHm8dafocn6I72Ur+lCf0ISUhOBJLyNn1pCqPFGDuo0SQGn8Ru9aBFs8Z4p/OVJvw2XayJsM0FdqZ0cIZouHb6J7WUb1CitiB8VudIObStLMLS+vnMGHs75V2VWL/J2+IfPKIzvDlVj/D+hJInFTLxW2NsZYZAIEXhcY90iGiM8N5aCA/QstsZW5NyJND+1mt6HE6nVLUxwoV7YD7hVpcQp6Ahwx+LEX6/KFlH+Htj7GtttJWJqndPQplYZjTqY+6MdWi3pUw0G/vja7Vb9boy7hwXPmMeXjV27y3LCTO9bsvvwJM12pxoUtUfU/pjuSF58Jeel+WYPFTA1jRTfsvvw2USdahoedLhkZbkfGxGGxNMU+5sHe7BNWgMtODddkq38u7AnIqWLZ2GaHO9iVoM0gt4LpBhHdcUdIM2A9uNrLMrPBrDbdrClKzNJ+1/0r5KfKa6stiT1tQ4rZwlQ5MUUhoY0jr6BHhH+xJhAFcA3zGs+QdDxukAAAAASUVORK5CYII="/>
                                        </svg>
                                    </div>
                                    <div class="contacts__title-label">{{trans('contacts.Contact phone numbers')}}</div>
                                </div>
                                <div class="contacts__content">
                                    <div class="contacts__content-wrap">
                                        <div class="contacts__content-phones">
                                            <div class="contacts__content-phones-item">
                                                <div class="contacts__content-phones-item-label">{{trans('contacts.Georgia')}}:</div>
                                                <div class="contacts__content-phones-item-data">
                                                    <a class="phone" href="tel:+995514411199">+ 995 514 41 11 99</a>
                                                    <a class="viber" href="viber://chat?number=+375291111575">
                                                        <svg width="20" aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="viber"
                                                             role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                             class="svg-inline--fa fa-viber fa-w-16">
                                                            <path fill="currentColor"
                                                                  d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"
                                                                  class=""></path>
                                                        </svg>
                                                    </a>
                                                    <a class="telegram" href="tg://resolve?domain=+375291111575">
                                                        <svg width="20" aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="telegram-plane" role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 448 512" class="svg-inline--fa fa-telegram-plane fa-w-14">
                                                            <path fill="currentColor"
                                                                  d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"
                                                                  class=""></path>
                                                        </svg>
                                                    </a>
                                                    <a class="whatsapp" href="whatsapp://send?phone=+375291111575">
                                                        <svg width="20" aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="whatsapp" role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 448 512" class="svg-inline--fa fa-whatsapp fa-w-14">
                                                            <path fill="currentColor"
                                                                  d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"
                                                                  class=""></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="contacts__content-phones-item">
                                                <div class="contacts__content-phones-item-label">{{trans('contacts.Belarus')}}:</div>
                                                <div class="contacts__content-phones-item-data">
                                                    <a class="phone" href="tel:+375291111575">+375 29 111 15 75</a>
                                                    <a class="viber" href="viber://chat?number=+375291111575">
                                                        <svg width="20" aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="viber"
                                                             role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                             class="svg-inline--fa fa-viber fa-w-16">
                                                            <path fill="currentColor"
                                                                  d="M444 49.9C431.3 38.2 379.9.9 265.3.4c0 0-135.1-8.1-200.9 52.3C27.8 89.3 14.9 143 13.5 209.5c-1.4 66.5-3.1 191.1 117 224.9h.1l-.1 51.6s-.8 20.9 13 25.1c16.6 5.2 26.4-10.7 42.3-27.8 8.7-9.4 20.7-23.2 29.8-33.7 82.2 6.9 145.3-8.9 152.5-11.2 16.6-5.4 110.5-17.4 125.7-142 15.8-128.6-7.6-209.8-49.8-246.5zM457.9 287c-12.9 104-89 110.6-103 115.1-6 1.9-61.5 15.7-131.2 11.2 0 0-52 62.7-68.2 79-5.3 5.3-11.1 4.8-11-5.7 0-6.9.4-85.7.4-85.7-.1 0-.1 0 0 0-101.8-28.2-95.8-134.3-94.7-189.8 1.1-55.5 11.6-101 42.6-131.6 55.7-50.5 170.4-43 170.4-43 96.9.4 143.3 29.6 154.1 39.4 35.7 30.6 53.9 103.8 40.6 211.1zm-139-80.8c.4 8.6-12.5 9.2-12.9.6-1.1-22-11.4-32.7-32.6-33.9-8.6-.5-7.8-13.4.7-12.9 27.9 1.5 43.4 17.5 44.8 46.2zm20.3 11.3c1-42.4-25.5-75.6-75.8-79.3-8.5-.6-7.6-13.5.9-12.9 58 4.2 88.9 44.1 87.8 92.5-.1 8.6-13.1 8.2-12.9-.3zm47 13.4c.1 8.6-12.9 8.7-12.9.1-.6-81.5-54.9-125.9-120.8-126.4-8.5-.1-8.5-12.9 0-12.9 73.7.5 133 51.4 133.7 139.2zM374.9 329v.2c-10.8 19-31 40-51.8 33.3l-.2-.3c-21.1-5.9-70.8-31.5-102.2-56.5-16.2-12.8-31-27.9-42.4-42.4-10.3-12.9-20.7-28.2-30.8-46.6-21.3-38.5-26-55.7-26-55.7-6.7-20.8 14.2-41 33.3-51.8h.2c9.2-4.8 18-3.2 23.9 3.9 0 0 12.4 14.8 17.7 22.1 5 6.8 11.7 17.7 15.2 23.8 6.1 10.9 2.3 22-3.7 26.6l-12 9.6c-6.1 4.9-5.3 14-5.3 14s17.8 67.3 84.3 84.3c0 0 9.1.8 14-5.3l9.6-12c4.6-6 15.7-9.8 26.6-3.7 14.7 8.3 33.4 21.2 45.8 32.9 7 5.7 8.6 14.4 3.8 23.6z"
                                                                  class=""></path>
                                                        </svg>
                                                    </a>
                                                    <a class="telegram" href="tg://resolve?domain=+375291111575">
                                                        <svg width="20" aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="telegram-plane" role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 448 512" class="svg-inline--fa fa-telegram-plane fa-w-14">
                                                            <path fill="currentColor"
                                                                  d="M446.7 98.6l-67.6 318.8c-5.1 22.5-18.4 28.1-37.3 17.5l-103-75.9-49.7 47.8c-5.5 5.5-10.1 10.1-20.7 10.1l7.4-104.9 190.9-172.5c8.3-7.4-1.8-11.5-12.9-4.1L117.8 284 16.2 252.2c-22.1-6.9-22.5-22.1 4.6-32.7L418.2 66.4c18.4-6.9 34.5 4.1 28.5 32.2z"
                                                                  class=""></path>
                                                        </svg>
                                                    </a>
                                                    <a class="whatsapp" href="whatsapp://send?phone=+375291111575">
                                                        <svg width="20" aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="whatsapp" role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 448 512" class="svg-inline--fa fa-whatsapp fa-w-14">
                                                            <path fill="currentColor"
                                                                  d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"
                                                                  class=""></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="contacts__content-phones-item">
                                                <div class="contacts__content-phones-item-label">{{trans('contacts.Email')}}:</div>
                                                <div class="contacts__content-phones-item-data">
                                                    <a class="phone" href="mailto:info@sunnygeorgia.travel">info@SunnyGeorgia.Travel</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="icons-block">
                                            <a href="https://www.facebook.com/SunnyGeorgia.Travel/" rel="nofollow" target="_blank">
                                                <svg width="10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path fill="currentColor"
                                                          d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                                                </svg>
                                            </a>
                                            <a href="https://vk.com/sunnygeorgia.travel" rel="nofollow" target="_blank">
                                                <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                    <path fill="currentColor"
                                                          d="M545 117.7c3.7-12.5 0-21.7-17.8-21.7h-58.9c-15 0-21.9 7.9-25.6 16.7 0 0-30 73.1-72.4 120.5-13.7 13.7-20 18.1-27.5 18.1-3.7 0-9.4-4.4-9.4-16.9V117.7c0-15-4.2-21.7-16.6-21.7h-92.6c-9.4 0-15 7-15 13.5 0 14.2 21.2 17.5 23.4 57.5v86.8c0 19-3.4 22.5-10.9 22.5-20 0-68.6-73.4-97.4-157.4-5.8-16.3-11.5-22.9-26.6-22.9H38.8c-16.8 0-20.2 7.9-20.2 16.7 0 15.6 20 93.1 93.1 195.5C160.4 378.1 229 416 291.4 416c37.5 0 42.1-8.4 42.1-22.9 0-66.8-3.4-73.1 15.4-73.1 8.7 0 23.7 4.4 58.7 38.1 40 40 46.6 57.9 69 57.9h58.9c16.8 0 25.3-8.4 20.4-25-11.2-34.9-86.9-106.7-90.3-111.5-8.7-11.2-6.2-16.2 0-26.2.1-.1 72-101.3 79.4-135.6z"></path>
                                                </svg>
                                            </a>
                                            <a href="https://www.instagram.com/sunnygeorgia.travel/" rel="nofollow" target="_blank">
                                                <svg width="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path fill="currentColor"
                                                          d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"
                                                          class=""></path>
                                                </svg>
                                            </a>
                                            <a href="https://ok.ru/group/54547512623220" rel="nofollow" target="_blank">
                                                <svg width="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                    <path fill="currentColor"
                                                          d="M275.1 334c-27.4 17.4-65.1 24.3-90 26.9l20.9 20.6 76.3 76.3c27.9 28.6-17.5 73.3-45.7 45.7-19.1-19.4-47.1-47.4-76.3-76.6L84 503.4c-28.2 27.5-73.6-17.6-45.4-45.7 19.4-19.4 47.1-47.4 76.3-76.3l20.6-20.6c-24.6-2.6-62.9-9.1-90.6-26.9-32.6-21-46.9-33.3-34.3-59 7.4-14.6 27.7-26.9 54.6-5.7 0 0 36.3 28.9 94.9 28.9s94.9-28.9 94.9-28.9c26.9-21.1 47.1-8.9 54.6 5.7 12.4 25.7-1.9 38-34.5 59.1zM30.3 129.7C30.3 58 88.6 0 160 0s129.7 58 129.7 129.7c0 71.4-58.3 129.4-129.7 129.4s-129.7-58-129.7-129.4zm66 0c0 35.1 28.6 63.7 63.7 63.7s63.7-28.6 63.7-63.7c0-35.4-28.6-64-63.7-64s-63.7 28.6-63.7 64z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </contacts-page>
        </main>
    </div>
@endsection
