@extends('site.layouts.new-app')
@push('header')
    <title>{{ $meta['title'] ?? 'Вопросы и ответы' }}</title>
    <meta property="og:title" content="{{$meta['title'] ?? 'Вопросы и ответы'}}"/>
    <meta property="og:description" content="{{$meta['description'] ?? ''}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{route('qa')}}"/>

    <link rel="preload" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}" as="style">
    {{--  @foreach ($cssChunks as $filename)--}}
    {{--    <link rel="preload" href="{{ URL::asset($filename) }}" as="style">--}}
    {{--  @endforeach--}}
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages-vendors.css')) }}">
    <link rel="stylesheet" href="{{ URL::asset(get_webpack_asset('information-pages.css')) }}">

    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages-vendors.js')) }}"
            defer></script>
    <script type="text/javascript" src="{{ URL::asset(get_webpack_asset('information-pages.js')) }}" defer></script>
@endpush

@section('content')
    <!--main-->
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
            <div class="container">
                <div class="nav-holder">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="question-tab" data-toggle="tab" href="#question"
                                       role="tab" aria-controls="question" aria-selected="true">
                                        Самые частозадаваемые вопросы
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="city-tab" data-toggle="tab" href="#city" role="tab"
                                       aria-controls="city" aria-selected="false">
                                        О грузии, визе и прочее
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-content bg-white px-3 py-4 question" id="tab-content">
                    <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
                        <span class="text-help">Здесь вы найдете ответы на все вопросы касательно работы сайта</span>
                        <div class="row justify-content-center no-gutters">
                            <div class="col-md-10">
                                <h2>Профиль / Аккаунт</h2>
                                <div id="profile" class="accordion">
                                    <div class="accordion-item">
                                        <h5 id="questions-profile-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-profile" aria-expanded="false"
                                                    aria-controls="questions-profile">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Регистрация, вход, социальные сети
                                            </button>
                                        </h5>
                                        <div id="questions-profile" class="collapse"
                                             aria-labelledby="questions-profile-head" data-parent="#profile">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-profile-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question1-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question1"
                                                                        aria-expanded="false" aria-controls="question1">
                                                                    Зачем мне регистрироваться?
                                                                </button>
                                                            </h5>
                                                            <div id="question1" class="collapse"
                                                                 aria-labelledby="question1-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Регистрация даёт вам возможность полноценно
                                                                            использовать все возможности портала и
                                                                            доступ в Ваш личный кабинет.</p>
                                                                        <p>При регистрации необходимо указать свой адрес
                                                                            электронной почты и телефон. Пользователь
                                                                            может создавать только один аккаунт/учётную
                                                                            запись</p>
                                                                        <p>После регистрации пользователям становится
                                                                            доступен весь функционал портала.</p>
                                                                        <div class="d-sm-flex mt-3">
                                                                            <div class="question-ribbon">
                                                                                <div class="ribbon-faq">
                                                                                    Гостям
                                                                                </div>
                                                                            </div>
                                                                            <ul class="list-arrow mt-3 mt-sm-0">
                                                                                <li>Возможность бронировать услуги
                                                                                    представленные на сайте.
                                                                                </li>
                                                                                <li>Возможность связаться с менеджерами
                                                                                    сайта в приоритетном порядке.
                                                                                </li>
                                                                                <li>Отправлять сообщения поставщику
                                                                                    услуг прямо с сайта.
                                                                                </li>
                                                                                <li>Возможность сохранить "в избранное"
                                                                                    понравившиеся объекты для для
                                                                                    дальнейшего сравнения и выбора при
                                                                                    бронировании.
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="d-sm-flex">
                                                                            <div class="question-ribbon">
                                                                                <div class="ribbon-faq">
                                                                                    Партнёрам
                                                                                </div>
                                                                                <span class="ribbon-help">
                                                                                    Владельцам жилья, тур операторам, гидам
                                                                                </span>
                                                                            </div>
                                                                            <ul class="list-arrow mt-3 mt-sm-0">
                                                                                <li>Публиковать свои объекты размещения
                                                                                    и прочие туристические услуги на
                                                                                    портале для дальнейшего бронирования
                                                                                    гостями.
                                                                                </li>
                                                                                <li>Указывать доступность и цены для
                                                                                    ваших услуг и объектов размещения
                                                                                    используя "Календарь".
                                                                                </li>
                                                                                <li>Самостоятельно устанавливать условия
                                                                                    оплаты, предоплаты и отмены
                                                                                    бронирования.
                                                                                </li>
                                                                                <li>Устанавливать скидки, сезонные цены
                                                                                    или специальные предложения на
                                                                                    определенные даты или групп гостей.
                                                                                </li>
                                                                                <li>Подтверждать или отклонять заявки на
                                                                                    бронирование прямо из кабинета
                                                                                    сайта.
                                                                                </li>
                                                                                <li>Вести переписку с потенциальным
                                                                                    клиентом непосредственно из личного
                                                                                    кабинета
                                                                                </li>
                                                                                <li>Иметь статистику просмотров вашего
                                                                                    объявления, статистику продаж и
                                                                                    другие показатели.
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question2-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question2"
                                                                        aria-expanded="false" aria-controls="question2">
                                                                    Как зарегистрироваться/создать аккаунт?
                                                                </button>
                                                            </h5>
                                                            <div id="question2" class="collapse"
                                                                 aria-labelledby="question2-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>В верхнем правом углу кликните на
                                                                            "Регистрация" Далее следуйте инструкциям в
                                                                            появившемся всплывающем окне. Можно
                                                                            зарегистрироваться с помощью действующих
                                                                            аккаунтов Facebook, Google
                                                                            или иного, чья иконка есть на вплывающем
                                                                            окне регистрации. Также вам придётся
                                                                            подтвердить, что указанный при регис трации
                                                                            е-майл ваш, перейдя по ссылке которую мы вам
                                                                            отправим
                                                                            сразу после регистрации.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question3-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question3"
                                                                        aria-expanded="false" aria-controls="question3">
                                                                    Как и зачем подтверждать свой номер телефона?
                                                                </button>
                                                            </h5>
                                                            <div id="question3" class="collapse"
                                                                 aria-labelledby="question3-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Чтобы подтвердить свой номер телефона,
                                                                            войдите в Мой кабинет. В левом меню кликните
                                                                            на "Профиль" затем в поле " мой телефон
                                                                            введите номер в международном формате и
                                                                            кликните "Добавить".</p>
                                                                        <p>После клика на "Добавить" появится
                                                                            дополнительное поле для ввода кода
                                                                            подтверждения, который будет выслан на
                                                                            указанный вами номер.</p>
                                                                        <p>Вводите код из СМС в поле для ввода и
                                                                            нажимаете "Подтвердить".</p>
                                                                        <p>Подтверждение вашего номера необходимо для
                                                                            нескольких целей: верификация вас как
                                                                            уникального пользователя, целей
                                                                            безопасности, возможностей коммуникации.
                                                                            После оплаты вы получаете
                                                                            подтверждение о заказе, в том числе
                                                                            посредством СМС, гостю/поставщику услуг
                                                                            будет сообщен ваш номер после оплаты
                                                                            услуги.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question4-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question4"
                                                                        aria-expanded="false" aria-controls="question4">
                                                                    Как связать свой аккаунт с профилями в социальных
                                                                    сетях?
                                                                </button>
                                                            </h5>
                                                            <div id="question4" class="collapse"
                                                                 aria-labelledby="question4-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Чтобы связать свой аккаунт с профилями в
                                                                            социальных сетях, войдите в Кабинет. В левом
                                                                            меню кликните на "Настройки".</p>
                                                                        <p>В подменю кликните на "Соцсети". Затем из
                                                                            списка кликните на нужную социальную сеть и
                                                                            вас переадресует на страницу авторизации для
                                                                            ввода данных. Для добавления другой соцсети
                                                                            проделайте
                                                                            описанное выше действие ещё раз.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question5-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question5"
                                                                        aria-expanded="false" aria-controls="question5">
                                                                    Я зарегистрирован. Как мне войти на сайт?
                                                                </button>
                                                            </h5>
                                                            <div id="question5" class="collapse"
                                                                 aria-labelledby="question5-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Для того, чтобы войти на сайт/авторизоваться
                                                                            кликните в правом верхнем углу сайта на
                                                                            "Вход" далее введите свой адрес электронной
                                                                            почты и пароль указанный при регистрации
                                                                            кликните
                                                                            на "Войти". Или кликните на иконку одной из
                                                                            соц.сетей (если привязана).</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question6-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question6"
                                                                        aria-expanded="false" aria-controls="question6">
                                                                    Как создать новый пароль?
                                                                </button>
                                                            </h5>
                                                            <div id="question6" class="collapse"
                                                                 aria-labelledby="question6-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Если вы забыли пароль кликните на "Вход"
                                                                            правом верхнем углу сайта. В появившемся
                                                                            окне авторизации кликните на "Напомнить
                                                                            Пароль".</p>
                                                                        <p>Далее в появившемся окне вам надо указать
                                                                            емайл на который вы регистрировали
                                                                            аккаунт/учётную запись и кликнуть
                                                                            "Выслать".</p>
                                                                        <p>На указанный емайл вам будет выслано письмо с
                                                                            инструкциями для смены пароля.</p>
                                                                        <p>Для создания нового пароля вам надо войти в
                                                                            свой "Кабинет" далее "Настройки" и там
                                                                            выбрать "Сменить пароль" . После чего вам
                                                                            надо будет ввести старый/действующий пароль
                                                                            а затем дважды
                                                                            вести новый и кликнуть "Сменить".</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question7-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question7"
                                                                        aria-expanded="false" aria-controls="question7">
                                                                    Сообщение об ошибке при регистрации: "Такой email
                                                                    уже используется" или "Такой номер телефона уже
                                                                    используется."
                                                                </button>
                                                            </h5>
                                                            <div id="question7" class="collapse"
                                                                 aria-labelledby="question7-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>"Такой email уже используется" или "Такой
                                                                            номер телефона уже используется".</p>
                                                                        <p>В большинстве случаем это означает
                                                                            следующее:</p>
                                                                        <ul class="mb-0 pl-4">
                                                                            <li>Вероятно вы ошиблись при вводе
                                                                                электронной почты - внимательно
                                                                                проверьте правильность написания,
                                                                                исправьте ошибку и продолжите
                                                                                регистрацию.
                                                                            </li>
                                                                            <li>Возможно вы уже зарегистрированы на
                                                                                данный емайл и пытаетесь ещё раз пройти
                                                                                регистрацию.
                                                                            </li>
                                                                        </ul>
                                                                        <p>Внимание: на один емайл можно
                                                                            зарегистрировать только один аккаунт!</p>
                                                                        <p>Если вы уверенны, что ввели емайл правильно и
                                                                            до этого не регистрировались, тогда
                                                                            свяжитесь с нами по адресу
                                                                            <a href="mailto:support@sunnyGeorgia.travel">support@SunnyGeorgia.Travel</a>и
                                                                            опишите проблему.</p>
                                                                        <p>Наша служба поддержки постарается выяснить и
                                                                            решить проблему максимально быстро.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question8-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question8"
                                                                        aria-expanded="false" aria-controls="question8">
                                                                    Письма от SunnyGeorgia.Travel не доходят на мою
                                                                    электронную почту.
                                                                </button>
                                                            </h5>
                                                            <div id="question8" class="collapse"
                                                                 aria-labelledby="question8-head"
                                                                 data-parent="#questions-profile-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>В таком случае надо сделать следующее:</p>
                                                                        <ul class="mb-0 pl-4">
                                                                            <li>Зайти в "Кабинет" далее в "Профиль" и
                                                                                проверить правильность написания емайла,
                                                                                если найдены ошибки исправить
                                                                            </li>
                                                                            <li>Если же всё указанно правильно проверить
                                                                                своем электронном ящике проверить папку
                                                                                "Спам"
                                                                            </li>
                                                                            <li>Проверить не переполнен ли ваш почтовый
                                                                                ящик.
                                                                            </li>
                                                                        </ul>
                                                                        <p>Если всё проверенно и и письма не доходят
                                                                            свяжитесь с нами:
                                                                            <a href="mailto:support@sunnyGeorgia.travel">support@SunnyGeorgia.Travel</a>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2>Бронирование</h2>
                                <div id="booking" class="accordion">
                                    <div class="accordion-item">
                                        <h5 id="questions-booking-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-booking" aria-expanded="false"
                                                    aria-controls="questions-booking">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Поиск и бронирование жилья, экскурсии или тура
                                            </button>
                                        </h5>
                                        <div id="questions-booking" class="collapse"
                                             aria-labelledby="questions-booking-head" data-parent="#booking">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-booking-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question9-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question9"
                                                                        aria-expanded="false" aria-controls="question9">
                                                                    Как это работает?
                                                                </button>
                                                            </h5>
                                                            <div id="question9" class="collapse"
                                                                 aria-labelledby="question9-head"
                                                                 data-parent="#questions-booking-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>SunnyGeorgia.Travel дает возможность всем
                                                                            гостям Грузии выбрать лучшие предложения от
                                                                            гостеприимных тур операторов и арендодателей
                                                                            по всей Грузии удобно, легко и выгодно.</p>
                                                                        <p>Мы не берем комиссию с туристов, все услуги и
                                                                            объекты размещения представленные на нашем
                                                                            сайте тщательно проверяются нашими
                                                                            сотрудниками.</p>
                                                                        <p>Наши администраторы всегда на связи и готовы
                                                                            помочь Вам с любыми вопросами.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question10-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question10"
                                                                        aria-expanded="false"
                                                                        aria-controls="question10">
                                                                    Как найти жилье, экскурсию или тур?
                                                                </button>
                                                            </h5>
                                                            <div id="question10" class="collapse"
                                                                 aria-labelledby="question10-head"
                                                                 data-parent="#questions-booking-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Вы определились с направлением, городом или
                                                                            местом отдыха, тогда есть два способа
                                                                            подобрать жильё, экскурсию или тур в
                                                                            интересующем в ас месте:</p>
                                                                        <ol class="mb-0 pl-4">
                                                                            <li>Поиск через форму поиска на главной
                                                                                странице сайта указав интересующие вас
                                                                                параметры. Выбрав тип услуги, город или
                                                                                место, даты нажимаете на кнопку поиска и
                                                                                получаете результаты
                                                                                отображенные н а странице в виде списка
                                                                                с возможностью дополнительного уточнения
                                                                                параметров поиска, находящегося в правой
                                                                                части страницы.
                                                                            </li>
                                                                            <li>Навести курсор на "Направления" в "шапке
                                                                                сайта" и кликнув на интересующий вас
                                                                                город или место вы перейдёте на
                                                                                страничку с информацией о данном
                                                                                городе/месте.
                                                                            </li>
                                                                        </ol>
                                                                        <p>На странице под фотографиями вы найдёте меню
                                                                            с: "Основная информация", "Жильё",
                                                                            "Экскурсии", "Туры" Кликнув на любое из них
                                                                            получите соответствующую информацию по
                                                                            данному городу/месту</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question11-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question11"
                                                                        aria-expanded="false"
                                                                        aria-controls="question11">
                                                                    Как узнать точные цены и и доступность в
                                                                    интересующие меня даты?
                                                                </button>
                                                            </h5>
                                                            <div id="question11" class="collapse"
                                                                 aria-labelledby="question11-head"
                                                                 data-parent="#questions-booking-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Для этого вам надо выбрать услугу и указать
                                                                            дату и кликнуть на поиск/смотреть.</p>
                                                                        <p>Система выдаст вам все результаты доступные
                                                                            на данные даты и цены.</p>
                                                                        <p>Если вы смотрели доступность и цены
                                                                            конкретного объекта, то вы также получите
                                                                            результаты на странице, или оповещение, если
                                                                            объект будет не доступен.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question12-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question12"
                                                                        aria-expanded="false"
                                                                        aria-controls="question12">
                                                                    Как задать вопрос владельцу жилья?
                                                                </button>
                                                            </h5>
                                                            <div id="question12" class="collapse"
                                                                 aria-labelledby="question12-head"
                                                                 data-parent="#questions-booking-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Для начала рекомендуем задать вопрос нашему
                                                                            оператору, что будет значительно
                                                                            быстрей.</p>
                                                                        <p>Чтобы связаться с арендодателем/поставщиком
                                                                            услуги для уточнения деталей до оплаты
                                                                            заказа перейдите на страницу описания
                                                                            объекта и кликните "Связаться с
                                                                            поставщиком". В поле "Ваш
                                                                            вопрос" напишите свой вопрос и нажмите
                                                                            "Отправить".</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question13-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question13"
                                                                        aria-expanded="false"
                                                                        aria-controls="question13">
                                                                    Как забронировать жильё, тур или экскурсию (услугу)?
                                                                </button>
                                                            </h5>
                                                            <div id="question13" class="collapse"
                                                                 aria-labelledby="question13-head"
                                                                 data-parent="#questions-booking-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>На странице выбранного жилья/услуги укажите
                                                                            даты и количество гостей.</p>
                                                                        <p>В случае если вы бронируете номер в отеле,
                                                                            вам надо будет также выбрать номер из
                                                                            списка.</p>
                                                                        <p>Далее вы нажимаете кнопку "Забронировать"
                                                                            после нажатия вы перейдёте на страницу с
                                                                            "Подробности заказа". Если всё указанно
                                                                            верно нажимаете кнопку "Перейти к оплате".
                                                                            Далее вы будете
                                                                            перенаправлены на платёжную страницу банка
                                                                            партнера для оплаты предоплаты/оплаты.</p>
                                                                        <p>В некоторых случаях вместо кнопки
                                                                            "Забронировать" будет кнопка "Отправить
                                                                            запрос". Это для объектов размещения и
                                                                            услуг, которые требуют дополнительного
                                                                            подтверждения со стороны тур
                                                                            оператора ил арендодателя.</p>
                                                                        <p>Сообщении о бронировании/ запросе на
                                                                            бронирование будет отправлено поставщику а
                                                                            также на ваш почтовый ящик.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question14-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question14"
                                                                        aria-expanded="false"
                                                                        aria-controls="question14">
                                                                    Как изменить заявку на бронирование?
                                                                </button>
                                                            </h5>
                                                            <div id="question14" class="collapse"
                                                                 aria-labelledby="question14-head"
                                                                 data-parent="#questions-booking-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Если ваша заявка ещё не подтверждён вы можете
                                                                            отменить или изменить её.</p>
                                                                        <p>Для этого надо перейти в "Мой кабинет" в меню
                                                                            выбрать мои заказы, далее из выбрать
                                                                            интересующий вас заявку и кликнуть на неё.
                                                                            Откроются детали, вы можете кликнуть на "
                                                                            Отменить" или
                                                                            "Редактировать".</p>
                                                                        <p>Если выбрали "Редактировать", после внесения
                                                                            изменений нажмите "Сохранить".</p>
                                                                        <p>Поставщик получит новое уведомление с
                                                                            внесёнными изменениями, а вам на е-майл
                                                                            придёт письмо о редактировании заявки.</p>
                                                                        <p>После подтверждения поставщиком вы получите
                                                                            сообщение об этом на почтовый ящик. Далее
                                                                            вам надо будет оплатить услугу.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 id="questions-pay-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-pay" aria-expanded="false"
                                                    aria-controls="questions-pay">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Оплата
                                            </button>
                                        </h5>
                                        <div id="questions-pay" class="collapse" aria-labelledby="questions-pay-head"
                                             data-parent="#booking">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-pay-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question15-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question15"
                                                                        aria-expanded="false"
                                                                        aria-controls="question15">
                                                                    Какими способами я могу внести предоплату/оплату за
                                                                    бронирование?
                                                                </button>
                                                            </h5>
                                                            <div id="question15" class="collapse"
                                                                 aria-labelledby="question15-head"
                                                                 data-parent="#questions-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>На данный момент к оплате принимаются карты
                                                                            Visa, Master Card и American Expres</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question16-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question16"
                                                                        aria-expanded="false"
                                                                        aria-controls="question16">
                                                                    Как подтверждается оплата/предоплата?
                                                                </button>
                                                            </h5>
                                                            <div id="question16" class="collapse"
                                                                 aria-labelledby="question16-head"
                                                                 data-parent="#questions-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Подтверждение о платеже отравляется на ваш
                                                                            адрес электронной почты, указанный при
                                                                            регистрации, а также отображается в вашем
                                                                            "Кабинете".</p>
                                                                        <p>На сайте в разделе "Мои заказы".</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question17-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question17"
                                                                        aria-expanded="false"
                                                                        aria-controls="question17">
                                                                    Плачу ли я комиссию за пользование сайтом?
                                                                </button>
                                                            </h5>
                                                            <div id="question17" class="collapse"
                                                                 aria-labelledby="question17-head"
                                                                 data-parent="#questions-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>С гостя не взимаются никакие комиссионные за
                                                                            использования сайта или за бронирование
                                                                            объектов размещения или иных услуг на
                                                                            сайте.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question18-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question18"
                                                                        aria-expanded="false"
                                                                        aria-controls="question18">
                                                                    Мой платеж отклонён, что делать?
                                                                </button>
                                                            </h5>
                                                            <div id="question18" class="collapse"
                                                                 aria-labelledby="question18-head"
                                                                 data-parent="#questions-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>В первую очередь проверьте правильность
                                                                            введенных вами данных:</p>
                                                                        <p>Номер карты и срок действия вашей карты.</p>
                                                                        <p>Убедитесь, что с вашей карты возможны платежи
                                                                            через Интернет(on-line).</p>
                                                                        <p>В некоторых случаях on-line платежи
                                                                            отключены:</p>
                                                                        <p>Владелец карты сам выставил блокировку на
                                                                            платежи on-line.</p>
                                                                        <p>Зарплатная карта с установленной по умолчанию
                                                                            блокировкой платежей on-line.</p>
                                                                        <p>На дебетовой карте не достаточно средств для
                                                                            совершения платежа.</p>
                                                                        <p>По данным вопросам вам следует обратиться в
                                                                            ваш банк.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 id="questions-cancel-pay-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-cancel-pay" aria-expanded="false"
                                                    aria-controls="questions-cancel-pay">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Отмена бронирования
                                            </button>
                                        </h5>
                                        <div id="questions-cancel-pay" class="collapse"
                                             aria-labelledby="questions-cancel-pay-head" data-parent="#booking">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-cancel-pay-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question19-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question19"
                                                                        aria-expanded="false"
                                                                        aria-controls="question19">
                                                                    Как отменить бронирование?
                                                                </button>
                                                            </h5>
                                                            <div id="question19" class="collapse"
                                                                 aria-labelledby="question19-head"
                                                                 data-parent="#questions-cancel-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Для отмены бронирования вам надо войти в
                                                                            "Кабинет" далее в "Мои заказы" и кликнуть по
                                                                            интересующему вас заказу. Далее вы попадёте
                                                                            на страницу заказа где вам надо кликнуть
                                                                            "Отменить".</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question20-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question20"
                                                                        aria-expanded="false"
                                                                        aria-controls="question20">
                                                                    Правила отмены бронирования
                                                                </button>
                                                            </h5>
                                                            <div id="question20" class="collapse"
                                                                 aria-labelledby="question20-head"
                                                                 data-parent="#questions-cancel-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Правила отмены бронирования устанавливаются
                                                                            конкретным поставщиком услуг для каждого
                                                                            конкретного продукта/услуги.</p>
                                                                        <p>Правила отмены указанны в карточке продукта.
                                                                            Т.е. с правилами можно ознакомиться до
                                                                            предоплаты/оплаты за услугу/продукт, и
                                                                            оплачивая вы подтверждаете, что ознакомлены
                                                                            и даёте согласие
                                                                            на указанных условиях.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question21-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question21"
                                                                        aria-expanded="false"
                                                                        aria-controls="question21">
                                                                    Что означает доплата на месте?
                                                                </button>
                                                            </h5>
                                                            <div id="question21" class="collapse"
                                                                 aria-labelledby="question21-head"
                                                                 data-parent="#questions-cancel-pay-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Доплата на месте означает ту часть оплаты,
                                                                            которую вы оплачиваете на месте поставщику
                                                                            услуг. Оплата, как правило разбита на две
                                                                            части. Одну часть, предоплату, вы
                                                                            оплачиваете посредством
                                                                            сайта остальное доплачиваете на месте
                                                                            непосредственно поставщику услуг.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h5 id="questions-services-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-services" aria-expanded="false"
                                                    aria-controls="questions-services">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Заселение и/или оказание услуги
                                            </button>
                                        </h5>
                                        <div id="questions-services" class="collapse"
                                             aria-labelledby="questions-services-head" data-parent="#booking">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-services-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question22-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question22"
                                                                        aria-expanded="false"
                                                                        aria-controls="question22">
                                                                    Мне вернут деньги, если жильё не соответствует
                                                                    заявленному?
                                                                </button>
                                                            </h5>
                                                            <div id="question22" class="collapse"
                                                                 aria-labelledby="question22-head"
                                                                 data-parent="#questions-services-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Да, мы вернём вам все деньги и в срочном
                                                                            порядке поможем подобрать подобное жильё или
                                                                            лучше.</p>
                                                                        <p>Для этого вам нужно связаться с нами по
                                                                            телефону
                                                                            <a href="tel:995557161100">+995 557 16 11
                                                                                00</a>или иным способом.</p>
                                                                        <p>На сайте размещено несколько тысяч объектов.
                                                                            Некоторые объекты отмечены, как
                                                                            "Проверенно", "Cheked". Мы можем
                                                                            гарантировать, что объекты с таким значком
                                                                            проверенны нашими сотрудниками
                                                                            на соответствие заявленному.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question23-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question23"
                                                                        aria-expanded="false"
                                                                        aria-controls="question23">
                                                                    Мне вернут деньги, если каким-то причинам не
                                                                    состоялась?
                                                                </button>
                                                            </h5>
                                                            <div id="question23" class="collapse"
                                                                 aria-labelledby="question23-head"
                                                                 data-parent="#questions-services-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Если экскурсия не состоялась по причине
                                                                            поставщика услуг, то деньги будут вам
                                                                            возвращены в полной размере.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question24-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question24"
                                                                        aria-expanded="false"
                                                                        aria-controls="question24">
                                                                    Отзывы
                                                                </button>
                                                            </h5>
                                                            <div id="question24" class="collapse"
                                                                 aria-labelledby="question24-head"
                                                                 data-parent="#questions-services-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Вы можете оставить отзыв о каждой
                                                                            забронированной услуге, которой вы
                                                                            воспользовались. Через несколько дней после
                                                                            оказания услуги вам будет выслана ссылка,
                                                                            перейдя по которой, вы сможете
                                                                            оставить свой отзыв об услуге и оценить
                                                                            качество услуг. Чем правдивее будет отзыв
                                                                            тем лучше для всех участников.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2>Безопасность</h2>
                                <div id="security" class="accordion">
                                    <div class="accordion-item">
                                        <h5 id="questions-security-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-security" aria-expanded="false"
                                                    aria-controls="questions-security">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Личные данные, безопасность оплаты и гарантии бронирования
                                            </button>
                                        </h5>
                                        <div id="questions-security" class="collapse"
                                             aria-labelledby="questions-security-head" data-parent="#security">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-security-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question25-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question25"
                                                                        aria-expanded="false"
                                                                        aria-controls="question25">
                                                                    На сколько безопасен платеж?
                                                                </button>
                                                            </h5>
                                                            <div id="question25" class="collapse"
                                                                 aria-labelledby="question25-head"
                                                                 data-parent="#questions-security-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Использовать антивирусные программы с
                                                                            актуальными и обновлёнными базами.</p>
                                                                        <p>Не сохранять карточные данные.</p>
                                                                        <p>Не сообщать карточные третьим лицам.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question26-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question26"
                                                                        aria-expanded="false"
                                                                        aria-controls="question26">
                                                                    Какие плюсы и гарантии при бронировании через
                                                                    SunnyGeorgia.Travel?
                                                                </button>
                                                            </h5>
                                                            <div id="question26" class="collapse"
                                                                 aria-labelledby="question26-head"
                                                                 data-parent="#questions-security-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Бронируя услуги на сайте SunnyGeorgia.Travel
                                                                            вы получаете:</p>
                                                                        <ol class="mb-0 pl-4">
                                                                            <li>Широчайший выбор туристических услуг и
                                                                                продуктов на территории Грузии.
                                                                            </li>
                                                                            <li>Все поставщики проходят обязательную
                                                                                проверку. Почти все представленные
                                                                                объекты и иные туристические услуги
                                                                                проверены нашими сотрудниками на
                                                                                соответствие заявленным.
                                                                            </li>
                                                                            <li>Безопасное бронирование и возможность
                                                                                отмены согласно условиям поставщика.
                                                                            </li>
                                                                            <li>Мы постоянно проверяем актуальность и
                                                                                доступность представленных услуг.
                                                                            </li>
                                                                        </ol>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question27-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question27"
                                                                        aria-expanded="false"
                                                                        aria-controls="question27">
                                                                    Что делать, если мой учётная запись/аккаунт взломан?
                                                                </button>
                                                            </h5>
                                                            <div id="question27" class="collapse"
                                                                 aria-labelledby="question27-head"
                                                                 data-parent="#questions-security-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>В первую очередь смените пароль своей учётной
                                                                            записи/аккаунта и в случае, если пароль
                                                                            совпадает с паролем электронной почты
                                                                            сменить оба.</p>
                                                                        <p>Проверьте настройки в личном кабинете.</p>
                                                                        <p>Проверьте ваши объявления и актуальность
                                                                            информации в них.</p>
                                                                        <p>Проверьте ваши заказы на наличие заказов и
                                                                            убедитесь, что там только ваши заказы.</p>
                                                                        <p>Если вы не можете получить доступ к вашему
                                                                            кабинету/аккаунту - незамедлительно
                                                                            свяжитесь с нами –
                                                                            <a href="#!">контакты</a>.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question28-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question28"
                                                                        aria-expanded="false"
                                                                        aria-controls="question28">
                                                                    У меня возникли технические проблемы, что мне
                                                                    делать?
                                                                </button>
                                                            </h5>
                                                            <div id="question28" class="collapse"
                                                                 aria-labelledby="question28-head"
                                                                 data-parent="#questions-security-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Если у вас возникли какие либо тех. проблемы
                                                                            пр работе с сайтом например вы нашли ошибку
                                                                            в работе сайта или возникли другие -
                                                                            свяжитесь с нами.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2>Размещение объявлений на сайте</h2>
                                <div id="advertisement" class="accordion">
                                    <div class="accordion-item">
                                        <h5 id="questions-advertisement-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-advertisement" aria-expanded="false"
                                                    aria-controls="questions-advertisement">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Условия размещения, отображения и продвижения объектов жилья
                                            </button>
                                        </h5>
                                        <div id="questions-advertisement" class="collapse"
                                             aria-labelledby="questions-advertisement-head"
                                             data-parent="#advertisement">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-advertisement-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question29-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question29"
                                                                        aria-expanded="false"
                                                                        aria-controls="question29">
                                                                    Кто может размещать объявления на
                                                                    SunnyGeorgia.Travel?
                                                                </button>
                                                            </h5>
                                                            <div id="question29" class="collapse"
                                                                 aria-labelledby="question29-head"
                                                                 data-parent="#questions-advertisement-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Разместить объявление о сдаче в аренду
                                                                            объекта может физическое или юридическое
                                                                            лицо являющееся собственником или
                                                                            действующее от имени собственника на
                                                                            основании доверенности или иному
                                                                            договору.</p>
                                                                        <p>Объявление о предоставлении туристических
                                                                            услуг может разместить юридическое или
                                                                            физическое лицо, которое имеет право на
                                                                            осуществление подобной деятельности на
                                                                            территории Грузии.</p>
                                                                        <p>Регистрация на сайте подразумевает
                                                                            автоматическое заключение договора оферты и
                                                                            необходимость верификации ваших данных после
                                                                            чего вам становится доступен весь
                                                                            партнёрский функционал
                                                                            "Кабинета".</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question30-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question30"
                                                                        aria-expanded="false"
                                                                        aria-controls="question30">
                                                                    Сколько стоит разместить объявление на сайте
                                                                    SunnyGeorgia.Travel?
                                                                </button>
                                                            </h5>
                                                            <div id="question30" class="collapse"
                                                                 aria-labelledby="question30-head"
                                                                 data-parent="#questions-advertisement-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Размещение объявления на сайте абсолютно
                                                                            бесплатно и размещается бессрочно!!!</p>
                                                                        <p>Но с каждого подтверждённого бронирования
                                                                            сайтом взимается процент от указанной вами
                                                                            цены для поддержки и развития проекта.</p>
                                                                        <p>Все зарегистрировавшиеся партнёры платят
                                                                            комиссионные от указанных цен:</p>
                                                                        <ul class="mb-0 pl-4">
                                                                            <li>Готовые пакетные Туры от 10%</li>
                                                                            <li>Объекты размещения от 12%</li>
                                                                            <li>Экскурсионные услуги от 12%</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question31-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question31"
                                                                        aria-expanded="false"
                                                                        aria-controls="question31">
                                                                    Как сделать мое объявление более привлекательным для
                                                                    гостей.
                                                                </button>
                                                            </h5>
                                                            <div id="question31" class="collapse"
                                                                 aria-labelledby="question31-head"
                                                                 data-parent="#questions-advertisement-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Опишите ваш объект или услугу максимально
                                                                            подробно для того чтобы ваши будущие гости
                                                                            смогли сформировать впечатление.</p>
                                                                        <p>Используйте качественные фотографии.</p>
                                                                        <p>Устанавливайте конкурентные цены с учётом
                                                                            спроса и сезонности!</p>
                                                                        <p>Будьте внимательны в обработке поступивших
                                                                            заявок на бронирование, чем быстрее ваш
                                                                            ответ на заявку тем больше вероятность
                                                                            успешного бронирования.</p>
                                                                        <p>Побудите ваших гостей оставлять отзывы о
                                                                            вашей услуге</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question32-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question32"
                                                                        aria-expanded="false"
                                                                        aria-controls="question32">
                                                                    Как поднять позицию моего объявления в общем поиске?
                                                                </button>
                                                            </h5>
                                                            <div id="question32" class="collapse"
                                                                 aria-labelledby="question32-head"
                                                                 data-parent="#questions-advertisement-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>После того как ваше объявление прошло
                                                                            модерацию в список подобных объектов с
                                                                            привязкой к выбранному городу/месту и
                                                                            позиция в поисковой выдаче определяется
                                                                            популярностью объекта. На
                                                                            популярность влияют следующие факторы:</p>
                                                                        <ul class="mb-0 pl-4">
                                                                            <li>Полнота представленной информации,
                                                                                подробность описания нашего
                                                                                объекта/услуги
                                                                            </li>
                                                                            <li>Качество фотографий</li>
                                                                            <li>Наличие положительных отзывов о вашем
                                                                                объекте/услуге и их количество
                                                                            </li>
                                                                            <li>Оперативность подтверждения заявок на
                                                                                бронирование
                                                                            </li>
                                                                            <li>Наличие или отсутствие отказов по
                                                                                подтверждённым и оплаченным заказам
                                                                            </li>
                                                                        </ul>
                                                                        <p>Также есть возможность привилегированного
                                                                            размещения ваших объявлений в поисковой
                                                                            выдаче.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h2>Работа с сайтом: профиль, объявления, цены и календарь, запросы и т.д.</h2>
                                <div id="site" class="accordion">
                                    <div class="accordion-item">
                                        <h5 id="questions-site-head">
                                            <button class="accordion-btn" data-toggle="collapse"
                                                    data-target="#questions-site" aria-expanded="false"
                                                    aria-controls="questions-site">

                                                <svg class="icon icon--double-arrow" width="32px" height="32px">
                                                    <use xlink:href="#double-arrow"></use>
                                                </svg>

                                                Как подтвердить или отклонить бронирование и отвечать на запросы гостей,
                                                установка правил?
                                            </button>
                                        </h5>
                                        <div id="questions-site" class="collapse" aria-labelledby="questions-site-head"
                                             data-parent="#site">
                                            <div class="row justify-content-center no-gutters mt-3">
                                                <div class="col-md-10">
                                                    <div id="questions-site-list" class="accordion">
                                                        <div class="accordion-item">
                                                            <h5 id="question33-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question33"
                                                                        aria-expanded="false"
                                                                        aria-controls="question33">
                                                                    Как правильно заполнить "Мой профиль"?
                                                                </button>
                                                            </h5>
                                                            <div id="question33" class="collapse"
                                                                 aria-labelledby="question33-head"
                                                                 data-parent="#questions-site-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Линк на
                                                                            <a href="#!">youtube.com</a>с видео уроком
                                                                            на грузинском</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question34-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question34"
                                                                        aria-expanded="false"
                                                                        aria-controls="question34">
                                                                    Как правильно создать объявление?
                                                                </button>
                                                            </h5>
                                                            <div id="question34" class="collapse"
                                                                 aria-labelledby="question34-head"
                                                                 data-parent="#questions-site-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Линк на
                                                                            <a href="#!">youtube.com</a>с видео уроком
                                                                            на грузинском</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question35-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question35"
                                                                        aria-expanded="false"
                                                                        aria-controls="question35">
                                                                    Как работать с Календарём и Ценами?
                                                                </button>
                                                            </h5>
                                                            <div id="question35" class="collapse"
                                                                 aria-labelledby="question35-head"
                                                                 data-parent="#questions-site-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Линк на
                                                                            <a href="#!">youtube.com</a>с видео уроком
                                                                            на грузинском</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question36-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question36"
                                                                        aria-expanded="false"
                                                                        aria-controls="question36">
                                                                    Как я узнаю о поступлении запроса или вопроса?
                                                                </button>
                                                            </h5>
                                                            <div id="question36" class="collapse"
                                                                 aria-labelledby="question36-head"
                                                                 data-parent="#questions-site-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Вам придет сообщение на емайл о поступлении
                                                                            запроса на бронирование, а также сообщение
                                                                            отобразится в "Кабинете". Там же вы увидите
                                                                            детали бронирования, подтвердить или
                                                                            отклонить запрос.</p>
                                                                        <p>Если от гостя поступит вопрос вы получите
                                                                            электронное письмо и уведомление в разделе
                                                                            "Сообщения" в "Кабинете".</p>
                                                                        <p>Там же вы можете ответить на заданный
                                                                            вопрос.</p>
                                                                        <p class="text-danger">Внимание: Обмениваться
                                                                            контактами в сообщениях запрещено!</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="accordion-item">
                                                            <h5 id="question37-head">
                                                                <button class="accordion-btn accordion-btn-inner accordion-ribbon-fix"
                                                                        data-toggle="collapse" data-target="#question37"
                                                                        aria-expanded="false"
                                                                        aria-controls="question37">
                                                                    Что такое "правила отмены бронирования" и как их
                                                                    установить?
                                                                </button>
                                                            </h5>
                                                            <div id="question37" class="collapse"
                                                                 aria-labelledby="question37-head"
                                                                 data-parent="#questions-site-list">
                                                                <div class="accordion-ribbon-fix">
                                                                    <div class="accordion-box">
                                                                        <p>Правила отмены бронирования - Устанавливаемые
                                                                            Вами условия, на которых может быть
                                                                            забронирована ваша услуга или объект
                                                                            размещения и на каких условиях может быть
                                                                            произведена отмена.
                                                                            В рамках предоставленных возможностей Вы
                                                                            можете:</p>
                                                                        <p>Вы можете установить размер предоплаты.</p>
                                                                        <p>Установить за сколько дней до начала оказания
                                                                            гость может отменить бронирование
                                                                            бесплатно.</p>
                                                                        <p>Все бронирования, срок исполнения которых
                                                                            начинается менее чем за 48 часов, не могут
                                                                            быть отменены!</p>
                                                                        <p>Правила и условия устанавливаются для каждого
                                                                            отдельного объявления. Для этого надо войти
                                                                            в "Кабинет" -> "Мои объявления" -> далее
                                                                            выберите то объявление для которого хотите
                                                                            поменять
                                                                            правила бронирования и отмены.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade city" id="city" role="tabpanel" aria-labelledby="city-tab">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row justify-content-center no-gutters">
                                    <div class="col-md-10">
                                        <h1>О Грузии</h1>
                                        <p>Гру́зия (Сакартве́ло) — государство в западной части Закавказья на восточном
                                            побережье Чёрного моря, некоторые относят к Передней Азии и Ближнему
                                            Востоку; другие рассматривают как часть современной Европы. Но наверняка
                                            можно сказать одно - это страна находится на границе, как Европы и Азии, так
                                            Севера и Юга. Первые упоминания о создании грузинского государства относятся
                                            к далёкому X веку. Однако самое ранее упоминание - это
                                            греческий миф об аргонавтах.</p>
                                        <p>Мы не будем описывать здесь все вехи истории, а лучше пригласим Вас увидеть
                                            воочию все красоты нашей гостеприимной страны!</p>
                                        <img src="/static/images/assets/question/about-map.png" alt="About Map">
                                        <span class="text-help">Ниже вы найдете ответы на самые частые вопросы</span>
                                        <h2>Нужна ли виза в Грузию?</h2>
                                        <p>Для граждан стран СНГ, которые желают посетить Грузию, виза не требуется.
                                            Также с июня 2015 года для жителей 94 стран (Россия, страны СНГ и Евросоюза
                                            и др.) введён безвизовый режим с правом нахождения на территории
                                            в течение года.</p>
                                        <h2>Как добраться</h2>
                                        <p>Есть несколько способов : по воздуху , морем и на машине, поезд- долго.</p>
                                        <p>Самый простой и быстрый способ - самолет, авиа сообщение налажено со многими
                                            крупными городами России, Беларуси, Украины , Казахстана Европы.</p>
                                        <p>Морем из России или Украины - по времени - несколько дней ( как повезет с
                                            погодой ) стоит почти также как и перелет.</p>
                                        <p>На машине - через Русско-Грузинскую границу. В данном варианте на границе
                                            лучше быть ночью - меньше очередь.</p>
                                        <p>Ни в коем случае не заезжайте на территорию Грузии из Абхазии или Южной
                                            Осетии.</p>
                                        <h2>Отношение к иностранцам?</h2>
                                        <p>Гость от бога, так говорят в Грузии. Такого гостеприимства вы не найдете ни в
                                            одной стране. Люди искренни доброжелательны в своей массе, поэтому все
                                            представления или фантазии, которые могли сформироваться в недавние
                                            годы рекомендуется оставить и воочию увидеть все как есть.</p>
                                        <h2>Подходит ли Грузия для семейного отдыха?</h2>
                                        <p>Да, это очень хороший вариант для семейного отдыха. В стране безопасно, не
                                            очень жарко, еда , как правило, натуральная ( без ГМО, пестицидов) много
                                            санаториев и курортов где параллельно можно поправить здоровье.</p>
                                        <h2>Языковой барьер</h2>
                                        <p>В мире известно всего 14 алфавитов и один из них грузинский.</p>
                                        <p>Если вы не знаете грузинского или одного из местных диалектов - ничего
                                            страшного. Большинство населения поймет вас и на русском, особенно поколение
                                            старше 35. Те кто помоложе, как правило, лучше поймут вас на английском.
                                            Все туристические указатели и таблички дублируются на английском.</p>
                                        <h2>Цены</h2>
                                        <p>Цены на проживание, особенно питание и проезд в Грузии не дорогие. В ходу
                                            местная валюта - Лари. Банки и обменные пункты есть в каждом более менее
                                            крупном населенном пункте. В зависимости от вашего бюджета вы можете
                                            найти как недорогие гостевые дома, недорогие кафе и рестораны так и люксовые
                                            заведения.</p>
                                        <h2>Климат и Погода</h2>
                                        <p>От субтропического на западе и к умеренному на восток до континентального.
                                            Надо смотреть в какой конкретно регион Грузии вы собрались - если это море
                                            то климат будет субтропический, мягкий и влажный. Если собрались
                                            заняться трекингом в горах - то даже летом без тёплой одежды не обойтись.
                                            Перед поездкой следует посмотреть среднее значение температур в конкретном
                                            направлении.</p>
                                        <h2>Безопасность</h2>
                                        <p>На данный момент Грузия - одна из самых безопасных стран мира. Этого удалось
                                            добиться за буквально несколько лет, теперь местные частенько могут не
                                            запирать свое жильё или даже оставлять ключи в машине и добавьте
                                            к этому знаменитое грузинское гостеприимство.</p>
                                        <p>Единственный момент который может насторожить это дорожное движение. Манера
                                            вождения многих местных джигитов порой не для слабонервных. Но не стоит
                                            боятся процент автомобильных аварий довольно низкий и правила стараются
                                            не нарушать ибо штрафы довольно высокие. Следит за порядком на дороге так
                                            называемый патруль, это клоны американских патрульных , которые в своей
                                            наглаженной форме и на современных машинах порой похожи на пришельцев.
                                            Кстати, помощь туристам их прямая обязанность, на "лапу" они не берут - не
                                            положено, так как все записывается.</p>
                                        <h2>Национальности</h2>
                                        <p>Единственный момент который может насторожить это дорожное движение. Манера
                                            вождения многих местных джигитов порой не для слабонервных. Но не стоит
                                            боятся процент автомобильных аварий довольно низкий и правила стараются
                                            не нарушать ибо штрафы довольно высокие. Следит за порядком на дороге так
                                            называемый патруль, это клоны американски.</p>
                                        <img src="/static/images/assets/question/nationalities.jpg" alt="Nationalities">
                                        <h2>Религии Грузии:</h2>
                                        <p>Единственный момент который может насторожить это дорожное движение. Манера
                                            вождения многих местных джигитов порой не для слабонервных. Но не стоит
                                            боятся процент автомобильных аварий довольно низкий и правила стараются
                                            не нарушать ибо штрафы довольно высокие. Следит за порядком на дороге так
                                            называемый патруль, это клоны американски.</p>
                                        <img src="/static/images/assets/question/religion.jpg" alt="Religion">
                                        <h2>Что ещё делать в грузии ?</h2>
                                        <p>Все зависит от ваших интересов в первую очередь: любите море - на здоровье ,
                                            хотите экстрима - езжайте в горы, займитесь альпинизмом или рафтингом,
                                            любителям древности- замки и крепости, их огромное множество, надо
                                            поправить здоровье - езжайте в специализированные курорты, любите
                                            современную электронную музыку - вам на Гем фест. Любите вкусно поесть - вам
                                            к нам ))</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 city-aside mt-4 mt-md-0">
                                <span class="text-help">Грузия</span>
                                <span class="text-help">Флаг</span>
                                <div class="flag">
                                    <span class="flag-icon flag-icon-ge mx-auto d-block"></span>
                                </div>
                                <div class="arms">
                                    <img src="/static/images/assets/question/arms.png" alt="Arms">
                                </div>
                                <ul class="city-info list-unstyled">
                                    <li>
                                        <strong>Дата независимости:</strong>
                                        <span>9 апреля 1991 года</span>
                                    </li>
                                    <li>
                                        <strong>Официальные язык:</strong>
                                        <span>Грузинский</span>
                                    </li>
                                    <li>
                                        <strong>Население:</strong>
                                        <span>3 729 500 человек (2015)</span>
                                    </li>
                                    <li>
                                        <strong>Площадь:</strong>
                                        <span>69 700 км²
                                            <br>без Южной Осетии
                                            <br>и Абхазии — 57200 км²</span>
                                    </li>
                                    <li>
                                        <strong>Столица:</strong>
                                        <span>Тбилиси
                                            <br>население: 1,173 миллион</span>
                                    </li>
                                    <li>
                                        <strong>Крупнейшие города:</strong>
                                        <span>Тбилиси, Кутаиси, Батуми, Рустави, Зугдиди, Гори, Поти</span>
                                    </li>
                                    <li>
                                        <strong>Валюта:</strong>
                                        <span>Грузинский лари</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <!--end main-->
@endsection
