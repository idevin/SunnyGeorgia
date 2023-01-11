<!-- BEGIN: Aside Menu -->
<div
        id="m_ver_menu"
        class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
        data-menu-vertical="true"
        data-menu-scrollable="false" data-menu-dropdown-timeout="500"
>
    <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
        @role('user|partner')
        <li class="m-menu__item  {{Request::routeIs('cabinet:dashboard') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:dashboard')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-tachometer-alt"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Dashboard')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__item  {{Request::routeIs('cabinet:profile.view') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:profile.view')}}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-user"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
                                                {{trans('cabinet/index.Profile')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endrole
        @role('user')
        {{--<li class="m-menu__item  {{Request::routeIs('cabinet:user:bookings.index') ?'m-menu__item--active':''}}"--}}
        {{--aria-haspopup="true">--}}
        {{--<a href="{{route('cabinet:user:bookings.index')}}" class="m-menu__link ">--}}
        {{--<i class="m-menu__link-icon flaticon-line-graph"></i>--}}
        {{--<span class="m-menu__link-title">--}}
        {{--<span class="m-menu__link-wrap">--}}
        {{--<span class="m-menu__link-text">--}}
        {{--{{trans('cabinet/index.Bookings')}}--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        <li class="m-menu__item  {{Request::routeIs('cabinet:orders.*') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:orders.index')}}" class="m-menu__link ">
                {{--<i class="m-menu__link-icon flaticon-folder-2"></i>--}}
                <i class="m-menu__link-icon fa fa-suitcase"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Orders')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endrole
        @if(!Auth::user()->hasRole('partner'))
            <li class="m-menu__item  {{Request::routeIs('cabinet:profile.become_partner') ?'m-menu__item--active':''}}"
                aria-haspopup="true">
                <a href="{{route('cabinet:profile.become_partner')}}" class="m-menu__link ">
                    {{--<i class="m-menu__link-icon flaticon-folder-2"></i>--}}
                    <i class="m-menu__link-icon flaticon-add"></i>
                    <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Become a partner')}}
											</span>
										</span>
									</span>
                </a>
            </li>
        @endif
        @role('partner')
        <li class="m-menu__section">
            <h4 class="m-menu__section-text">
                {{trans('cabinet/index.Partner')}}
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>


        <li class="m-menu__item m-menu__item--submenu {{Request::routeIs('cabinet:partner:profile.*')||Request::routeIs('cabinet:partner:billing.*') ?'m-menu__item--open m-menu__item--expanded':''}}"
            aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="#" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon fa fa-cubes"></i>
                <span class="m-menu__link-text">
                    {{trans('cabinet/index.My company')}}
									</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu"
                 style="display: {{Request::routeIs('cabinet:partner:profile.*')||Request::routeIs('cabinet:partner:billing.*') ?'block':'none'}};">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">

                    <li class="m-menu__item  {{Request::routeIs('cabinet:partner:profile.*') ? 'm-menu__item--active' : ''}}"
                        aria-haspopup="true">
                        <a href="{{route('cabinet:partner:profile.view')}}" class="m-menu__link ">
                            <i class="m-menu__link-icon flaticon-list ">
                                <span></span>
                            </i>
                            <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Profile')}}
											</span>
										</span>
									</span>
                        </a>
                    </li>
{{--                    <li class="m-menu__item  {{Request::routeIs('cabinet:partner:billing.*') ? 'm-menu__item--active' : ''}}"--}}
{{--                        aria-haspopup="true">--}}
{{--                        <a href="{{route('cabinet:partner:billing.view')}}" class="m-menu__link ">--}}
{{--                            <i class="m-menu__link-icon flaticon-piggy-bank ">--}}
{{--                                <span></span>--}}
{{--                            </i> <span class="m-menu__link-title">--}}
{{--										<span class="m-menu__link-wrap">--}}
{{--											<span class="m-menu__link-text">--}}
{{--												{{trans('cabinet/index.Billing')}}--}}
{{--											</span>--}}
{{--                                            @php--}}
{{--                                                $partner = \Auth::user()->partner;--}}
{{--                                            @endphp--}}
{{--                                            @if(empty($partner->bank_number) || empty($partner->bank_recipient))--}}
{{--                                                <span class="m-menu__link-badge">--}}
{{--												<span class="m-badge m-badge--danger" title="Fill payment information">--}}
{{--													!--}}
{{--												</span>--}}
{{--											</span>--}}
{{--                                            @endif--}}
{{--										</span>--}}
{{--									</span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </li>


        {{--<li class="m-menu__item  {{Request::routeIs('cabinet:partner:hotels.index') ? 'm-menu__item--active' : ''}}"--}}
        {{--aria-haspopup="true">--}}
        {{--<a href="{{route('cabinet:partner:hotels.index')}}" class="m-menu__link ">--}}
        {{--<i class="m-menu__link-icon flaticon-line-graph"></i>--}}
        {{--<span class="m-menu__link-title">--}}
        {{--<span class="m-menu__link-wrap">--}}
        {{--<span class="m-menu__link-text">--}}
        {{--Property--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="m-menu__item  {{Request::routeIs('cabinet:partner:hotels.create') ? 'm-menu__item--active' : ''}}"--}}
        {{--aria-haspopup="true">--}}
        {{--<a href="{{route('cabinet:partner:hotels.create')}}" class="m-menu__link ">--}}
        {{--<i class="m-menu__link-icon flaticon-line-graph"></i>--}}
        {{--<span class="m-menu__link-title">--}}
        {{--<span class="m-menu__link-wrap">--}}
        {{--<span class="m-menu__link-text">--}}
        {{--Add Property--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        <li class="m-menu__item  {{Request::routeIs('cabinet:partner:tours.index') ? 'm-menu__item--active' : ''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:partner:tours.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-globe "></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Tours')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__item  {{Request::routeIs('cabinet:partner:tours.create') ? 'm-menu__item--active' : ''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:partner:tours.create')}}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-add"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Add new tour')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__item  {{Request::routeIs('cabinet:partner:tours.booking.*') ? 'm-menu__item--active' : ''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:partner:tours.booking.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-book"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Tour bookings')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__item  {{Request::routeIs('cabinet:partner:excursions.index') ? 'm-menu__item--active' : ''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:partner:excursions.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-globe"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Excursions')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__item  {{Request::routeIs('cabinet:partner:excursions.create') ? 'm-menu__item--active' : ''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:partner:excursions.create')}}" class="m-menu__link ">
                <i class="m-menu__link-icon flaticon-add"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Add new excursion')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        <li class="m-menu__item  {{Request::routeIs('cabinet:partner:excursions.booking.*') ? 'm-menu__item--active' : ''}}"
            aria-haspopup="true">
            <a href="{{route('cabinet:partner:excursions.booking.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-book"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Excursion bookings')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        {{--<li class="m-menu__item  {{Request::routeIs('cabinet:partner:excursions.index') ? 'm-menu__item--active' : ''}}"--}}
        {{--aria-haspopup="true">--}}
        {{--<a href="{{route('cabinet:partner:excursions.index')}}" class="m-menu__link ">--}}
        {{--<i class="m-menu__link-icon flaticon-line-graph"></i>--}}
        {{--<span class="m-menu__link-title">--}}
        {{--<span class="m-menu__link-wrap">--}}
        {{--<span class="m-menu__link-text">--}}
        {{--Excursions--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        {{--<li class="m-menu__item  {{Request::routeIs('cabinet:partner:excursions.create') ? 'm-menu__item--active' : ''}}"--}}
        {{--aria-haspopup="true">--}}
        {{--<a href="{{route('cabinet:partner:excursions.create')}}" class="m-menu__link ">--}}
        {{--<i class="m-menu__link-icon flaticon-line-graph"></i>--}}
        {{--<span class="m-menu__link-title">--}}
        {{--<span class="m-menu__link-wrap">--}}
        {{--<span class="m-menu__link-text">--}}
        {{--Add Excursion--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        @endrole
        @role(['admin','seo', 'staff'])
        <li class="m-menu__section">
            <h4 class="m-menu__section-text">
                {{trans('cabinet/index.Admin control')}}
            </h4>
            <i class="m-menu__section-icon flaticon-more-v3"></i>
        </li>

        @permission('users-*')
        <li class="m-menu__item  {{Request::routeIs('control:users.*') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:users.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-users"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Users')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        @permission('tours-booking-view')
        <li class="m-menu__item  {{Request::routeIs('control:tours.booking.*') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:tours.booking.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-book"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Tour orders')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        @permission('tours-*')
        <li class="m-menu__item  {{Request::routeIs('control:tours.index') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:tours.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-globe"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Tours')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        @permission('excursions-booking-view')
        <li class="m-menu__item  {{Request::routeIs('control:excursions.booking.*') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:excursions.booking.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-book"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Excursion bookings')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        @permission('excursions-*')
        <li class="m-menu__item  {{Request::routeIs('control:excursions.index') || Request::routeIs('control:excursions.edit') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:excursions.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-globe"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Excursions')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        @permission('billing-payments-view')

        <li class="m-menu__item  {{Request::routeIs('control:payments.*') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:payments.index')}}" class="m-menu__link ">
                {{--<i class="m-menu__link-icon fa fa-credit-card"></i>--}}
                <i class="m-menu__link-icon fa fa-credit-card"></i>

                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Bank payments')}}
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        @permission('billing-index-view')
        <li class="m-menu__item  {{Request::routeIs('control:billing.*') ?'m-menu__item--active':''}}"
            aria-haspopup="true">
            <a href="{{route('control:billing.index')}}" class="m-menu__link ">
                <i class="m-menu__link-icon fa fa-money-bill-alt"></i>
                <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Billing
											</span>
										</span>
									</span>
            </a>
        </li>
        @endpermission
        {{--<li class="m-menu__item  {{Request::routeIs('control:payouts.*') ?'m-menu__item--active':''}}"--}}
        {{--aria-haspopup="true">--}}
        {{--<a href="{{route('control:payouts.index')}}" class="m-menu__link ">--}}
        {{--<i class="m-menu__link-icon flaticon-coins"></i>--}}
        {{--<span class="m-menu__link-title">--}}
        {{--<span class="m-menu__link-wrap">--}}
        {{--<span class="m-menu__link-text">--}}
        {{--{{trans('cabinet/index.Payouts')}}--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</span>--}}
        {{--</a>--}}
        {{--</li>--}}
        @permission('settings-*')

        <li class="m-menu__item m-menu__item--submenu {{Request::routeIs('control:options.*')||Request::routeIs('control:places.*') ?'m-menu__item--open m-menu__item--expanded':''}}"
            aria-haspopup="true" data-menu-submenu-toggle="hover">
            <a href="#" class="m-menu__link m-menu__toggle">
                <i class="m-menu__link-icon flaticon-cogwheel-1"></i>
                <span class="m-menu__link-text">
                    {{trans('cabinet/index.Settings')}}
									</span>
                <i class="m-menu__ver-arrow la la-angle-right"></i>
            </a>
            <div class="m-menu__submenu"
                 style="display: {{Request::routeIs('cabinet:partner:profile.*')||Request::routeIs('cabinet:partner:billing.*') ?'block':'none'}};">
                <span class="m-menu__arrow"></span>
                <ul class="m-menu__subnav">
                    @permission('settings-places-edit')

                    <li class="m-menu__item  {{Request::routeIs('control:places.*') ?'m-menu__item--active':''}}"
                        aria-haspopup="true">
                        <a href="{{route('control:places.index')}}" class="m-menu__link ">
                            <i class="m-menu__link-icon flaticon-placeholder"></i>
                            <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Places')}}
											</span>
										</span>
									</span>
                        </a>
                    </li>
                    @endpermission
                    @permission('settings-options-edit')
                    <li class="m-menu__item  {{Request::routeIs('control:options.*') ?'m-menu__item--active':''}}"
                        aria-haspopup="true">
                        <a href="{{route('control:options.index')}}" class="m-menu__link ">
                            <i class="m-menu__link-icon flaticon-list-2"></i>
                            <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												{{trans('cabinet/index.Options')}}
											</span>
										</span>
									</span>
                        </a>
                    </li>
                    @endpermission
                    @role('admin')
                    <li class="m-menu__item  {{Request::routeIs('control:permission.index') ?'m-menu__item--active':''}}"
                        aria-haspopup="true">
                        <a href="{{route('control:permission.index')}}" class="m-menu__link ">
                            <i class="m-menu__link-icon flaticon-list-2"></i>
                            <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Permissions
											</span>
										</span>
									</span>
                        </a>
                    </li>
                    @endpermission

                    @role('admin')
                    <li class="m-menu__item  {{Request::routeIs('control:pages.index') ?'m-menu__item--active':''}}"
                        aria-haspopup="true">
                        <a href="{{route('control:pages.index')}}" class="m-menu__link ">
                            <i class="m-menu__link-icon flaticon-list-2"></i>
                            <span class="m-menu__link-title">
										<span class="m-menu__link-wrap">
											<span class="m-menu__link-text">
												Pages
											</span>
										</span>
									</span>
                        </a>
                    </li>
                    @endpermission

                </ul>
            </div>
        </li>
        @endpermission
        @endrole
    </ul>
</div>
<!-- END: Aside Menu -->
