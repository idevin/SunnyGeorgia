@extends('site.layouts.app', ['meta'=>[
'title' => ($meta['title'])? $meta['title'] : 'Контакты',
'description' => ($meta['description'])? $meta['description'] : null
]])
@section('content')
    <!--main-->
    <main class="page-main">
        {!! $schema->toScript() !!}
        <div class="container">
            {{ Breadcrumbs::render(Request::route()->name) }}
        </div>
        <div class="contacts">
            <div class="container">
                <h1 class="h2 text-center text-uppercase mb-2 mt-4">Контактные телефоны:</h1>
                <div class="row">
                    <div class="col-md-4 col-lg-4 text-center text-md-left">

                        <div class="phone-row">
                            <div class="phone">
                                <div class="mb-3">Украина:</div>
                                <div class="phone-item">
                                    <div class="phone-icon">
                                        <svg class="icon icon--phone-call" width="32px" height="32px">
                                            <use xlink:href="#phone-call"></use>
                                        </svg>
                                    </div>
                                    <div class="phone-icon">
                                        <span class="flag-icon flag-icon-ua" style="width: 20px; height: 15px;"></span>
                                    </div>
                                    <div class="phone-number">
                                        <a href="tel:+380672033311">+380 672 03 33 11</a>
                                    </div>
                                    <ul class="phone-socials list-unstyled">
                                        <li>
                                            <svg class="icon icon--viber" width="31px" height="32px">
                                                <use xlink:href="#viber"></use>
                                            </svg>
                                        </li>
                                        <li>
                                            <svg class="icon icon--telegram" width="37px" height="32px">
                                                <use xlink:href="#telegram"></use>
                                            </svg>
                                        </li>
                                    </ul>
                                </div>
                                <div class="phone-item">
                                    <div class="phone-icon">
                                        <svg class="icon icon--phone-call" width="32px" height="32px">
                                            <use xlink:href="#phone-call"></use>
                                        </svg>
                                    </div>
                                    <div class="phone-icon">
                                        <span class="flag-icon flag-icon-ua" style="width: 20px; height: 15px;"></span>
                                    </div>
                                    <div class="phone-number">
                                        <a href="tel:+380672533311">+380 672 53 33 11</a>
                                    </div>
                                    <ul class="phone-socials list-unstyled">
                                        <li>
                                            <svg class="icon icon--viber" width="31px" height="32px">
                                                <use xlink:href="#viber"></use>
                                            </svg>
                                        </li>
                                        <li>
                                            <svg class="icon icon--telegram" width="37px" height="32px">
                                                <use xlink:href="#telegram"></use>
                                            </svg>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="phone-row">
                            <div class="phone">
                                <div class="mb-3">Грузия:</div>
                                <div class="phone-item">
                                    <div class="phone-icon">
                                        <svg class="icon icon--phone-call" width="32px" height="32px">
                                            <use xlink:href="#phone-call"></use>
                                        </svg>
                                    </div>
                                    <div class="phone-icon">
                                        <span class="flag-icon flag-icon-ge" style="width: 20px; height: 15px;"></span>
                                    </div>
                                    <div class="phone-number">
                                        <a href="tel:+995514511199">+995 514 51 11 99</a>
                                    </div>
                                    <ul class="phone-socials list-unstyled">
                                        <li>
                                            <svg class="icon icon--viber" width="31px" height="32px">
                                                <use xlink:href="#viber"></use>
                                            </svg>
                                        </li>
                                        <li>
                                            <svg class="icon icon--telegram" width="37px" height="32px">
                                                <use xlink:href="#telegram"></use>
                                            </svg>
                                        </li>
                                    </ul>
                                </div>
                                <div class="phone-item">
                                    <div class="phone-icon">
                                        <svg class="icon icon--phone-call" width="32px" height="32px">
                                            <use xlink:href="#phone-call"></use>
                                        </svg>
                                    </div>
                                    <div class="phone-icon">
                                        <span class="flag-icon flag-icon-ge" style="width: 20px; height: 15px;"></span>
                                    </div>
                                    <div class="phone-number">
                                        <a href="tel:+995514411199">+995 514 41 11 99</a>
                                    </div>
                                    <ul class="phone-socials list-unstyled">
                                        <li>
                                            <svg class="icon icon--viber" width="31px" height="32px">
                                                <use xlink:href="#viber"></use>
                                            </svg>
                                        </li>
                                        <li>Сотрудничество</li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4 text-center text-md-left">
                        <h2 class="h3 font-weight-normal text-uppercase">Мы в соц. сетях:</h2>
                        <div class="social">
                            @include('site.includes.social_links')
                        </div>
                    </div>
                </div>
                <h2 class="h2 text-center text-uppercase mb-2 mt-4">Отправте нам сообщение:</h2>
                <form method="post" action="{{route('contacts')}}" id="contact_form">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="contact-name">Ваше имя</label>
                                <input type="text" class="form-control" id="contact-name" required name="username">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="contact-email">Эл. почта:</label>
                                <input type="email" class="form-control" id="contact-email" required name="email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="contact-text">Сообщение</label>
                                <textarea class="form-control" name="message" id="contact-text" rows="8"
                                          maxlength="500"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group d-flex justify-content-end align-items-center align-items-sm-start flex-column flex-sm-row mt-3">
                        {{--<div class="captcha mb-3 mb-sm-0">--}}
                        {{--<label for="contact-code">Сколько будет {{$checkB}}+{{$checkA}} ?</label>--}}
                        {{--<input type="text" class="form-control" id="contact-code" required name="checksum">--}}
                        {{--</div>--}}
                        <button class="btn btn-outline-primary g-recaptcha"
                                data-sitekey="{{config('env.captchaKey')}}"
                                data-callback="onSubmit"
                        >Отправить</button>
                    </div>

                </form>
            </div>
            <div class="contacts-map">
                <div class="heading">
                    <h3 class="heading-title">

                        <svg class="icon icon--location" width="25px" height="32px">
                            <use xlink:href="#location"></use>
                        </svg>

                        Адрес:
                    </h3>
                    <span class="heading-subtitle">Пр. М. Абашидзе 50. Батуми , Грузия</span>
                </div>
                <contact-map></contact-map>
            </div>
        </div>
    </main>
    <!--end main-->
@endsection

@push('scripts')
    <script>
        function onSubmit(token) {
            document.getElementById("contact_form").submit();
        }
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
