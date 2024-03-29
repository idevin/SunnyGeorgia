@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        Base Controls
                    </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="#" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Forms
											</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Form Controls
											</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Base Inputs
											</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                         data-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#"
                           class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                            <i class="la la-plus m--hide"></i>
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="m-dropdown__wrapper">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__section m-nav__section--first m--hide">
															<span class="m-nav__section-text">
																Quick Actions
															</span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">
																	Activity
																</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">
																	Messages
																</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                    <span class="m-nav__link-text">
																	FAQ
																</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                    <span class="m-nav__link-text">
																	Support
																</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                            <li class="m-nav__item">
                                                <a href="#"
                                                   class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                    Submit
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-md-6">
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        Base Form Controls
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        The example form below demonstrates common HTML form elements that receive
                                        updated styles from Bootstrap with additional classes.
                                    </div>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control m-input" id="exampleInputEmail1"
                                           aria-describedby="emailHelp" placeholder="Enter email">
                                    <span class="m-form__help">
													We'll never share your email with anyone else.
												</span>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputPassword1">
                                        Password
                                    </label>
                                    <input type="password" class="form-control m-input" id="exampleInputPassword1"
                                           placeholder="Password">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                        Static:
                                    </label>
                                    <p class="form-control-static">
                                        email@example.com
                                    </p>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Example select
                                    </label>
                                    <select class="form-control m-input" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect2">
                                        Example multiple select
                                    </label>
                                    <select multiple="" class="form-control m-input" id="exampleSelect2">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleTextarea">
                                        Example textarea
                                    </label>
                                    <textarea class="form-control m-input" id="exampleTextarea" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-primary">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        Textual HTML5 Inputs
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        Here are examples of
                                        <code>
                                            .form-control
                                        </code>
                                        applied to each textual HTML5 input type:
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-text-input" class="col-2 col-form-label">
                                        Text
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="text" value="Artisanal kale"
                                               id="example-text-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-search-input" class="col-2 col-form-label">
                                        Search
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="search" value="How do I shoot web"
                                               id="example-search-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-email-input" class="col-2 col-form-label">
                                        Email
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="email" value="bootstrap@example.com"
                                               id="example-email-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-url-input" class="col-2 col-form-label">
                                        URL
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="url" value="https://getbootstrap.com"
                                               id="example-url-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-tel-input" class="col-2 col-form-label">
                                        Telephone
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="tel" value="1-(555)-555-5555"
                                               id="example-tel-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-password-input" class="col-2 col-form-label">
                                        Password
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="password" value="hunter2"
                                               id="example-password-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-number-input" class="col-2 col-form-label">
                                        Number
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="number" value="42"
                                               id="example-number-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-datetime-local-input" class="col-2 col-form-label">
                                        Date and time
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="datetime-local"
                                               value="2011-08-19T13:45:00" id="example-datetime-local-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-date-input" class="col-2 col-form-label">
                                        Date
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="date" value="2011-08-19"
                                               id="example-date-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-month-input" class="col-2 col-form-label">
                                        Month
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="month" value="2011-08"
                                               id="example-month-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-week-input" class="col-2 col-form-label">
                                        Week
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="week" value="2011-W33"
                                               id="example-week-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-time-input" class="col-2 col-form-label">
                                        Time
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="time" value="13:45:00"
                                               id="example-time-input">
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <label for="example-color-input" class="col-2 col-form-label">
                                        Color
                                    </label>
                                    <div class="col-10">
                                        <input class="form-control m-input" type="color" value="#563d7c"
                                               id="example-color-input">
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2"></div>
                                        <div class="col-10">
                                            <button type="reset" class="btn btn-success">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-secondary">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                                    <h3 class="m-portlet__head-text">
                                        Air Input Style
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        The example form below demonstrates common HTML form elements air(box shadowed)
                                        style.
                                    </div>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control m-input m-input--air"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Enter email">
                                    <span class="m-form__help">
												We'll never share your email with anyone else.
											</span>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputPassword1">
                                        Password
                                    </label>
                                    <input type="password" class="form-control m-input m-input--air"
                                           id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Example select
                                    </label>
                                    <select class="form-control m-input m-input--air" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect2">
                                        Example multiple select
                                    </label>
                                    <select multiple="" class="form-control m-input m-input--air" id="exampleSelect2">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleTextarea">
                                        Example textarea
                                    </label>
                                    <textarea class="form-control m-input m-input--air" id="exampleTextarea"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-accent">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                                    <h3 class="m-portlet__head-text">
                                        Pill Input Style
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        The example form below demonstrates common HTML form elements in pill and
                                        air(box shadowed) styles:
                                    </div>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control m-input m-input--air"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Enter email">
                                    <span class="m-form__help">
												We'll never share your email with anyone else.
											</span>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputPassword1">
                                        Password
                                    </label>
                                    <input type="password" class="form-control m-input m-input--air"
                                           id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Example select
                                    </label>
                                    <select class="form-control m-input m-input--air" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect2">
                                        Example multiple select
                                    </label>
                                    <select multiple="" class="form-control m-input m-input--air" id="exampleSelect2">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleTextarea">
                                        Example textarea
                                    </label>
                                    <textarea class="form-control m-input m-input--air" id="exampleTextarea"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-brand">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                </div>
                <div class="col-md-6">
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                                    <h3 class="m-portlet__head-text">
                                        Square Input Style
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control m-input m-input--square"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Enter email">
                                    <span class="m-form__help">
												We'll never share your email with anyone else.
											</span>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputPassword1">
                                        Password
                                    </label>
                                    <input type="password" class="form-control m-input m-input--square"
                                           id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Example select
                                    </label>
                                    <select class="form-control m-input m-input--square" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-metal">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                                    <h3 class="m-portlet__head-text">
                                        Square & Solid Input Style
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        The example form below demonstrates common HTML form elements solid background
                                        style:
                                    </div>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Email address
                                    </label>
                                    <input type="email" class="form-control m-input m-input--solid"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Enter email">
                                    <span class="m-form__help">
												We'll never share your email with anyone else.
											</span>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputPassword1">
                                        Password
                                    </label>
                                    <input type="password" class="form-control m-input m-input--solid"
                                           id="exampleInputPassword1" placeholder="Password">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                        Disabled
                                    </label>
                                    <input type="password" class="form-control m-input m-input--solid" disabled=""
                                           placeholder="Disabled">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Example select
                                    </label>
                                    <select class="form-control m-input m-input--solid" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleTextarea">
                                        Example textarea
                                    </label>
                                    <textarea class="form-control m-input m-input--solid" id="exampleTextarea"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-success">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
											<span class="m-portlet__head-icon m--hide">
												<i class="la la-gear"></i>
											</span>
                                    <h3 class="m-portlet__head-text">
                                        Disabled & Readonly States
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        Add the disabled or readonly boolean attribute on an input to prevent user
                                        interactions.
                                        Disabled inputs appear lighter and add a
                                        <code>
                                            not-allowed
                                        </code>
                                        cursor.
                                    </div>
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                        Disabled Input
                                    </label>
                                    <input type="email" class="form-control m-input" disabled="disabled"
                                           placeholder="Disabled input">
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                        Disabled select
                                    </label>
                                    <select class="form-control m-input" disabled="disabled">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleTextarea">
                                        Disabled textarea
                                    </label>
                                    <textarea class="form-control m-input" disabled="disabled" rows="3"></textarea>
                                </div>
                                <div class="form-group m-form__group">
                                    <label>
                                        Readonly Input
                                    </label>
                                    <input type="email" class="form-control m-input" readonly
                                           placeholder="Readonly input">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleTextarea">
                                        Readonly textarea
                                    </label>
                                    <textarea class="form-control m-input" readonly rows="3"></textarea>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-brand">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
										<span class="m-portlet__head-icon m--hide">
											<i class="la la-gear"></i>
										</span>
                                    <h3 class="m-portlet__head-text">
                                        Input Sizing
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        Set heights using classes like
                                        <code>
                                            .form-control-lg
                                        </code>
                                        , and set widths using grid column classes like
                                        <code>
                                            .col-lg-*
                                        </code>
                                    </div>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Large Input
                                    </label>
                                    <input type="email" class="form-control form-control-lg m-input"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Large input">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Default Input
                                    </label>
                                    <input type="email" class="form-control m-input" id="exampleInputEmail1"
                                           aria-describedby="emailHelp" placeholder="Large input">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        Small Input
                                    </label>
                                    <input type="email" class="form-control form-control-sm m-input"
                                           id="exampleInputEmail1" aria-describedby="emailHelp"
                                           placeholder="Large input">
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Large Select
                                    </label>
                                    <select class="form-control m-input form-control-lg" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Default Select
                                    </label>
                                    <select class="form-control m-input" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleSelect1">
                                        Small Select
                                    </label>
                                    <select class="form-control m-input form-control-sm" id="exampleSelect1">
                                        <option>
                                            1
                                        </option>
                                        <option>
                                            2
                                        </option>
                                        <option>
                                            3
                                        </option>
                                        <option>
                                            4
                                        </option>
                                        <option>
                                            5
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-accent">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
                                    <h3 class="m-portlet__head-text">
                                        Custom Controls
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right">
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10">
                                    <div class="alert m-alert m-alert--default" role="alert">
                                        For even more customization and cross browser consistency, use our completely
                                        custom form elements to replace the browser defaults. They’re built on top of
                                        semantic and accessible markup, so they’re solid replacements for any default
                                        form control.
                                    </div>
                                </div>
                                <div class="form-group1 m-form__group">
                                    <label for="exampleInputEmail1">
                                        Custom Select
                                    </label>
                                    <div></div>
                                    <select class="custom-select">
                                        <option selected>
                                            Open this select menu
                                        </option>
                                        <option value="1">
                                            One
                                        </option>
                                        <option value="2">
                                            Two
                                        </option>
                                        <option value="3">
                                            Three
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="exampleInputEmail1">
                                        File Browser
                                    </label>
                                    <div></div>
                                    <label class="custom-file">
                                        <input type="file" id="file2" class="custom-file-input">
                                        <span class="custom-file-control"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <button type="reset" class="btn btn-primary">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-secondary">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>

@endsection