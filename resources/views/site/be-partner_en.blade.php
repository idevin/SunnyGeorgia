@extends('site.layouts.new-app', ['meta'=>[
'title' => ($meta['title'])? $meta['title'] : "Стать партнером",
'description' => ($meta['description'])? $meta['description'] : null
]])

@push('header')
    <title>{{ $meta['title'] ?? 'Стать партнером' }}</title>
    <meta property="og:title" content="{{$meta['title'] ?? 'Стать партнером'}}"/>
    <meta property="og:description" content="{{$meta['description'] ?? ''}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('be-partner')}}"/>

    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    {{--  @foreach ($cssChunks as $filename)--}}
    {{--    <link rel="preload" href="{{ URL::asset($filename) }}" as="style">--}}
    {{--  @endforeach--}}
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">
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
            <div class="container main-content">
                <div class="container-fluid p-0">
                    <div class="row about no-gutters">
                        <div class="about-img col-sm-7">
                            <img src="/static/images/assets/about/work.jpg" alt="">
                        </div>
                        <div class="about-info col-sm-5">
                            <span class="about-title mb-4">Мы работаем с:</span>
                            <ul class="about-list list-unstyled">
                                <li>тур операторами</li>
                                <li>гидами и экскурсоводами</li>
                                <li>отелями, гостевыми домами и апартаментами</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bg-dark about-dark">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-md-4 col-xl-3">
                                <div class="advantages-item wow fadeInUp" data-wow-delay=".4s">
                                    <div class="advantages-icon d-flex justify-content-center align-items-center">

                                        <svg class="icon icon--maps" width="63px" height="32px">
                                            <use xlink:href="#maps"></use>
                                        </svg>

                                    </div>
                                    <p class="advantages-text text-center mt-sm-2 text-secondary font-weight-bold">
                                        Наша компания базируется в Грузии
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="advantages-item wow fadeInUp" data-wow-delay=".8s">
                                    <div class="advantages-icon d-flex justify-content-center align-items-center">

                                        <svg class="icon icon--time7" width="32px" height="32px">
                                            <use xlink:href="#time7"></use>
                                        </svg>

                                    </div>
                                    <p class="advantages-text text-center mt-sm-2 text-secondary font-weight-bold">
                                        Вы регистрируетесь на сайте и наш маркетинг начинает работать на Вас 24/7 - 365 дней
                                        в
                                        году
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="advantages-item wow fadeInUp" data-wow-delay="1.2s">
                                    <div class="advantages-icon d-flex justify-content-center align-items-center">

                                        <svg class="icon icon--registration" width="41px" height="32px">
                                            <use xlink:href="#registration"></use>
                                        </svg>

                                    </div>
                                    <p class="advantages-text text-center mt-sm-2 text-secondary font-weight-bold">
                                        Регистрация, размещение объявлений на сайте и сопровождение абсолютно Бесплатно!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="about-work advantages-about">
                    <div class="container">
                        <div class="row justify-content-between">
                            <div class="col-md-4 col-xl-3">
                                <div class="advantages-item wow fadeInUp" data-wow-delay=".4s">
                                    <div class="advantages-icon rounded-circle d-flex justify-content-center align-items-center">

                                        <svg class="icon icon--support" width="31px" height="32px">
                                            <use xlink:href="#support"></use>
                                        </svg>

                                    </div>
                                    <p class="advantages-text text-center mt-2 mt-sm-4">
                                        С нами легко связаться. Наши менеджеры всегда готовы помочь
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="advantages-item wow fadeInUp" data-wow-delay=".8s">
                                    <div class="advantages-icon rounded-circle d-flex justify-content-center align-items-center">

                                        <svg class="icon icon--multi-languages" width="45px" height="32px">
                                            <use xlink:href="#multi-languages"></use>
                                        </svg>

                                    </div>
                                    <p class="advantages-text text-center mt-2 mt-sm-4">
                                        Мы говорим на понятном вам языке.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-3">
                                <div class="advantages-item wow fadeInUp" data-wow-delay="1.2s">
                                    <div class="advantages-icon rounded-circle d-flex justify-content-center align-items-center">

                                        <svg class="icon icon--lari" width="28px" height="32px">
                                            <use xlink:href="#lari"></use>
                                        </svg>

                                    </div>
                                    <p class="advantages-text text-center mt-2 mt-sm-4">
                                        Расчёты с Партнерами в Грузинских лари
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="timeline">
                        <h2 class="timeline-heading">Как мы работаем</h2>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="row no-gutters">
                                        <div class="col-sm-6 timeline-left">
                                            <div class="timeline-list timeline-list-one">
                                                <div class="timeline-item">
                                                <span>

                                                    <svg class="icon icon--post-it" width="32px" height="32px">
                                                        <use xlink:href="#post-it"></use>
                                                    </svg>

                                                </span>
                                                    <p>Вы регистрируетесь на сайте и публикуете объявление о вашей
                                                        услуге</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters justify-content-end">
                                        <div class="col-sm-10 timeline-right">
                                            <div class="timeline-list timeline-list-two">
                                                <div class="timeline-item">
                                                <span>

                                                    <svg class="icon icon--booking" width="36px" height="32px">
                                                        <use xlink:href="#booking"></use>
                                                    </svg>

                                                </span>
                                                    <p>Гость бронирует услугу на сайте SunnyGeorgia.Travel</p>
                                                </div>
                                                <div class="timeline-item">
                                                <span>

                                                    <svg class="icon icon--website" width="26px" height="32px">
                                                        <use xlink:href="#website"></use>
                                                    </svg>

                                                </span>
                                                    <p>Оплачивает* предоплату/оплату за услугу на сайте
                                                        SunnyGeorgia.Travel</p>
                                                    <div class="timeline-hint">* На сайте SunnyGeorgia.Travel можно
                                                        забронировать только частично или полностью оплатив услугу
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-sm-6 timeline-left">
                                            <div class="timeline-list timeline-list-one">
                                                <div class="timeline-item">
                                                <span>

                                                    <svg class="icon icon--yes-no" width="88px" height="32px">
                                                        <use xlink:href="#yes-no"></use>
                                                    </svg>

                                                </span>
                                                    <p>Вы подтверждаете или отклоняете заказ*</p>
                                                    <div class="timeline-hint">* Условия бронирования и отмены
                                                        устанавливаются
                                                        Вами
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters justify-content-end">
                                        <div class="col-sm-10 timeline-right timeline-last">
                                            <div class="timeline-list timeline-list-two">
                                                <div class="timeline-item">
                                                <span>

                                                    <svg class="icon icon--card-money" width="24px" height="32px">
                                                        <use xlink:href="#card-money"></use>
                                                    </svg>

                                                </span>
                                                    <p>Мы зачисляем* Вам деньги за вычетом комиссии</p>
                                                    <div class="timeline-hint">* Деньги зачисляются на Ваш банковский счёт в
                                                        GEL
                                                        в установленные даты
                                                    </div>
                                                </div>
                                                <div class="timeline-item">
                                                <span>

                                                    <svg class="icon icon--client-money" width="32px" height="32px">
                                                        <use xlink:href="#client-money"></use>
                                                    </svg>

                                                </span>
                                                    <p>Оставшуюся часть оплаты клиент оплачивает Вам на месте</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--<div class="container">--}}
                    {{--<form action="#" class="about-form">--}}
                    {{--<h3 class="about-form-title">Регистрация</h3>--}}
                    {{--<div class="row align-items-end">--}}
                    {{--<div class="col-md-4">--}}
                    {{--<label for="about-first-name">Имя*</label>--}}
                    {{--<input type="text" class="form-control" id="about-first-name" required name="firtsname">--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mt-4 mt-md-0">--}}
                    {{--<label for="about-last-name">Фамилия*</label>--}}
                    {{--<input type="text" class="form-control" id="about-last-name" required name="lastname">--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mt-4 mt-md-0">--}}
                    {{--<label for="about-email">Электронная почта*</label>--}}
                    {{--<input type="email" class="form-control" id="about-email" required name="email">--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="row align-items-end mt-4">--}}
                    {{--<div class="col-md-4">--}}
                    {{--<label for="about-password">Пароль*</label>--}}
                    {{--<input type="password" class="form-control" id="about-password" required name="firtsname">--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mt-4 mt-md-0">--}}
                    {{--<label for="about-password2">Подтвердить пароль*</label>--}}
                    {{--<input type="password" class="form-control" id="about-password2" required name="password2">--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 mt-4 mt-md-0">--}}
                    {{--<button class="btn btn-outline-primary btn-block" type="submit">Стать партнером</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                    {{--</div>--}}
                </div>
            </div>

        </main>
    </div>>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush
