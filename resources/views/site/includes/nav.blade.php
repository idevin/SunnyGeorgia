<header-navigation inline-template>
    <nav>
        @stack('place_navigation')

        <div class="container">
            <div class="row">

                <div class="col col-lg-auto">
                    <a href="{{route('main')}}" class="navMainLink">
                        <img src="{{url('static/images/assets/logo/logo.svg')}}"
                             alt="Sunnygeorgia travel company logo"
                             class="navLogo"
                        ></a>
                </div>
                <div class="col-auto d-lg-none">
                    <button @click="mobileMenu=!mobileMenu" type="button" class="mobileMainMenu"
                            :class="{on:mobileMenu}">
                        <span></span>
                    </button>
                </div>
                <div class="col-12 col-lg-auto">
                    <div class="mainMenu hoverLinkAnimate">
                            <div class="mainMenuItem"><a href=""><span>{{trans('main.Directions')}}</span></a>
                                <div class="mainMenuDropDown mainMenuDropDown_left title hoverLinkAnimate not-uppercase">
                                    @foreach($composer_groupPlaces as $group)
                                        <ul>
                                            <li><a>{{$group->name}}</a></li>
                                            @foreach($group->places->sortBy('name') as $place)
                                                <li>
                                                    <a href="{{route($place->slug)}}">
                                                        {{$place->name}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mainMenuItem"><a href="{{route('tours.index')}}"><span>{{trans('main.Tours')}}</span></a></div>
                            <div class="mainMenuItem"><a href="{{route('excursions.index')}}"><span>{{trans('main.Excursions')}}</span></a></div>
                            <div class="mainMenuItem"><a href="https://test.sunnygeorgia.travel/blog" target="_blank"><span>{{trans('main.Blog')}}</span></a></div>
                    </div>
                </div>
                <div class="col text-lg-right">
                    <div class="mainMenu">
                        <user-block
                                dashboard-route="{{ route('cabinet:dashboard', [], false) }}"
                                logout-route="{{ route('logout', [], false) }}"
                                cabinet-text="{{ trans('auth.cabinet') }}"
                                logout-text="{{ trans('auth.logout') }}"
                                login-text="{{ trans('auth.login') }}"
                                registration-text="{{ trans('auth.registration') }}"
                        ></user-block>
                        <div class="mainMenuItem currency">
                            <span style="padding: 8px 18px 8px 8px;
                                             vertical-align: middle"
                            >
                                {{session('currency', config('currency.default'))}}
                                <i class="icon-arrow-down"></i>
                            </span>
                            <div class="mainMenuDropDown hoverLinkAnimate">
                                <ul>
                                    @foreach($composer_currencies as $cur)
                                        <li><a href="{{Request::url()}}?currency={{$cur->code}}&c={{bin2hex(random_bytes('6'))}}">{{$cur->code}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="mainMenuItem language">
                            <span class="language_img">
                                <img src="/static/images/assets/lang/{{LaravelLocalization::getCurrentLocale()}}.png"
                                     alt="">
                            </span>
                            <div class="mainMenuDropDown hoverLinkAnimate">
                                <ul>
                                    @foreach($alternates as $localeCode => $properties)
                                        <li>
                                            <a rel="alternate"
                                               hreflang="{{ $localeCode }}"
                                               href="{{ $properties['url'] }}"
                                            >
                                                <div class="language_img">
                                                    <img src="/static/images/assets/lang/{{ $localeCode }}.png" alt="">
                                                </div>
                                                {{ $localeCode }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-mobile-menu d-lg-none" :class="{show:mobileMenu}">

            <div ref="mobile1" class="main-mobile-menu__item">
                    <span
                            @click="mobileSubOpen(1)"
                            class="main-mobile-menu__item-title">
                        <div class="container">
                        {{trans('main.Directions')}}
                            <div
                                    class="main-mobile-menu__arrow">
                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="angle-down"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                     class="svg-inline--fa fa-angle-down fa-w-8 fa-3x">
                                    <path fill="currentColor"
                                          d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z"
                                          class=""></path>
                                </svg>
                            </div>
                        </div>
                             </span>

                <div class="main-mobile-menu__sub">
                    @foreach($composer_groupPlaces as $group)
                        <div class="main-mobile-menu__sub-item"
                             ref="mobile-sub{{$loop->iteration}}"
                        >
                            <a @click.prevent="mobileSubSubOpen({{$loop->iteration}})"
                               class="main-mobile-menu__sub-item-title"
                               href="#">
                                <div class="container">{{$group->name}}
                                    <div
                                            class="main-mobile-menu__sub-item-title__arrow">
                                        <svg aria-hidden="true" focusable="false" data-prefix="fal"
                                             data-icon="angle-down"
                                             role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                             class="svg-inline--fa fa-angle-down fa-w-8 fa-3x">
                                            <path fill="currentColor"
                                                  d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z"
                                                  class=""></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                            <div class="main-mobile-menu__sub-item__sub">
                                @foreach($group->places->sortBy('name') as $place)
                                    <a class="main-mobile-menu__sub-item__sub-item"
                                       href="{{route($place->slug)}}">
                                        <div class="container">
                                            {{$place->name}}
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
            <a class="main-mobile-menu__item" href="{{route('tours.index')}}">
                <span
                        class="main-mobile-menu__item-title"><div class="container">{{trans('main.Tours')}}</div></span>
            </a>
            <a class="main-mobile-menu__item"
               href="{{route('excursions.index')}}">
            <span
                    class="main-mobile-menu__item-title"><div
                        class="container">{{trans('main.Excursions')}}</div></span>
            </a>

            <div ref="mobile4" class="main-mobile-menu__item">
                    <span @click="mobileSubOpen(4)"
                          class="main-mobile-menu__item-title">
                        <div class="container">
                        {{trans('main.Account title')}}
                            <div
                                    class="main-mobile-menu__arrow">
                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="angle-down"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                     class="svg-inline--fa fa-angle-down fa-w-8 fa-3x">
                                    <path fill="currentColor"
                                          d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z"
                                          class=""></path>
                                </svg>
                            </div>
                        </div>
                             </span>

                <user-block-mobile
                        dashboard-route="{{ route('cabinet:dashboard', [], false) }}"
                        logout-route="{{ route('logout', [], false) }}"
                        cabinet-text="{{ trans('auth.cabinet') }}"
                        logout-text="{{ trans('auth.logout') }}"
                        login-text="{{ trans('auth.login') }}"
                        registration-text="{{ trans('auth.registration') }}"
                ></user-block-mobile>

            </div>

            <div ref="mobile2" class="main-mobile-menu__item">
                    <span
                            @click="mobileSubOpen(2)"
                            class="main-mobile-menu__item-title">
                        <div class="container">
                        {{trans('main.Language')}}
                            <div class="main-mobile-menu__add-text">
                                {{app()->getLocale()}}
                            </div>
                            <div
                                    class="main-mobile-menu__arrow">
                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="angle-down"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                     class="svg-inline--fa fa-angle-down fa-w-8 fa-3x">
                                    <path fill="currentColor"
                                          d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z"
                                          class=""></path>
                                </svg>
                            </div>
                        </div>
                             </span>

                <div class="main-mobile-menu__sub">
                    @foreach($alternates as $localeCode => $properties)
                        <div class="main-mobile-menu__sub-item">
                            <a class="main-mobile-menu__sub-item-title"
                               rel="alternate"
                               hreflang="{{ $localeCode }}"
                               href="{{ $properties['url'] }}"
                            >
                                <div class="container">
                                    {{ $properties['langNative'] }}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div ref="mobile3" class="main-mobile-menu__item">
                    <span @click="mobileSubOpen(3)"
                          class="main-mobile-menu__item-title">
                        <div class="container">
                        {{trans('main.Currency')}}
                            <div class="main-mobile-menu__add-text">
                                {{currency()->getUserCurrency()}}
                            </div>
                            <div
                                    class="main-mobile-menu__arrow">
                                <svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="angle-down"
                                     role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512"
                                     class="svg-inline--fa fa-angle-down fa-w-8 fa-3x">
                                    <path fill="currentColor"
                                          d="M119.5 326.9L3.5 209.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 287.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 327c-4.7 4.6-12.3 4.6-17-.1z"
                                          class=""></path>
                                </svg>
                            </div>
                        </div>
                             </span>

                <div class="main-mobile-menu__sub">
                    @foreach($composer_currencies as $cur)
                        <div class="main-mobile-menu__sub-item">
                            <a class="main-mobile-menu__sub-item-title"
                               href="{{Request::url()}}?currency={{$cur->code}}">
                                <div class="container">{{$cur->code}}
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
    </nav>

</header-navigation>
