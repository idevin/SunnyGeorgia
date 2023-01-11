<!-- BEGIN: Header -->
<header class="m-grid__item    m-header " data-minimize-offset="200" data-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-light">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="/" class="m-brand__logo-wrapper">
                            {{--Sunnygeorgia--}}
                            <img class="dashboard-logo" src="{{url('static/images/assets/logo/logo.svg')}}"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block
					 ">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark "
                        id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>
                <!-- END: Horizontal Menu -->
            <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click" aria-expanded="true">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                          @if($composer_user->avatar)
                                            <img src="{{$composer_user->avatar->url}}"
                                                 class="m--img-rounded m--marginless m--img-centered"
                                                 alt=""/>
                                            @else
                                            <img src="/assets/app/media/img/users/anonimus.png"
                                                 class="m--img-rounded m--marginless m--img-centered"
                                                 alt=""/>
                                            @endif
                                    </span>
                                    <span class="m-topbar__username m--hide">
                                        @if($composer_user->display_name)
                                            {{$composer_user->display_name}}
                                        @elseif($composer_user->first_name)
                                            {{$composer_user->first_name}} {{$composer_user->last_name}}
                                        @else
                                            {{$composer_user->email}}
                                        @endif
                                    </span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url({{url('/assets/app/media/img/misc/user_profile_bg.jpg')}}); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    @if($composer_user->avatar)
                                                        <img src="{{$composer_user->avatar->url}}"
                                                             class="m--img-rounded m--marginless" alt=""/>
                                                    @else
                                                        <img src="/assets/app/media/img/users/anonimus.png"
                                                             class="m--img-rounded m--marginless" alt=""/>
                                                    @endif
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">
                                                        {{$composer_user->first_name}} {{$composer_user->last_name}}
                                                    </span>
                                                    <span href="" class="m-card-user__email m--font-weight-300 m-link">
                                                        {{$composer_user->email}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
																	<span class="m-nav__section-text">
																		Section
																	</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{route('cabinet:profile.view')}}" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">
																					{{trans('cabinet/index.My Profile')}}
																				</span>
																			</span>
																		</span>
                                                        </a>
                                                    </li>
                                                    {{--<li class="m-nav__item">--}}
                                                    {{--<a href="header/profile.html" class="m-nav__link">--}}
                                                    {{--<i class="m-nav__link-icon flaticon-share"></i>--}}
                                                    {{--<span class="m-nav__link-text">--}}
                                                    {{--Activity--}}
                                                    {{--</span>--}}
                                                    {{--</a>--}}
                                                    {{--</li>--}}
                                                    {{--<li class="m-nav__item">--}}
                                                    {{--<a href="header/profile.html" class="m-nav__link">--}}
                                                    {{--<i class="m-nav__link-icon flaticon-chat-1"></i>--}}
                                                    {{--<span class="m-nav__link-text">--}}
                                                    {{--Messages--}}
                                                    {{--</span>--}}
                                                    {{--</a>--}}
                                                    {{--</li>--}}
                                                    {{--<li class="m-nav__separator m-nav__separator--fit"></li>--}}
                                                    {{--<li class="m-nav__item">--}}
                                                    {{--<a href="header/profile.html" class="m-nav__link">--}}
                                                    {{--<i class="m-nav__link-icon flaticon-info"></i>--}}
                                                    {{--<span class="m-nav__link-text">--}}
                                                    {{--FAQ--}}
                                                    {{--</span>--}}
                                                    {{--</a>--}}
                                                    {{--</li>--}}
                                                    {{--<li class="m-nav__item">--}}
                                                    {{--<a href="header/profile.html" class="m-nav__link">--}}
                                                    {{--<i class="m-nav__link-icon flaticon-lifebuoy"></i>--}}
                                                    {{--<span class="m-nav__link-text">--}}
                                                    {{--Support--}}
                                                    {{--</span>--}}
                                                    {{--</a>--}}
                                                    {{--</li>--}}
                                                    <li class="m-nav__separator m-nav__separator--fit"></li>
                                                    <li class="m-nav__item">
                                                        <a href="{{ route('cabinet-logout') }}"
                                                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                                           class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder"
                                                        >{{trans('auth.logout')}}</a>
                                                        <form id="logout-form" action="{{ route('cabinet-logout') }}"
                                                              method="POST"
                                                              style="display: none;"
                                                        >
                                                            {{ csrf_field() }}
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
<!-- END: Header -->
