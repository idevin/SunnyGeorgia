@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        User
                    </h3>
                </div>
                <div class="m-portlet__head-tools">
                    @include('control.users.block_buttons')
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--Begin::Main Portlet-->
            @php
                if($user->hasRole('partner'))
                        $width = 6;
                else
                $width = 12
            @endphp
            <div class="row">
                <div class="col-xl-{{$width}} col-lg-{{$width}}">
                    <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">

                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        User #{{$user->id}}
                                        {{$user->first_name}}
                                        {{$user->last_name}}
                                        <small> {{$user->email}}</small>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">

                            <table class="table m-table">
                                <tr class="m-table__row--brand">
                                    <td colspan="2">Details</td>
                                </tr>
                                <tr>
                                    <td>First name:</td>
                                    <td>{{$user->first_name}}</td>
                                </tr>
                                <tr>
                                    <td>Last name:</td>
                                    <td>{{$user->last_name}}</td>
                                </tr>
                                <tr>
                                    <td>Display name:</td>
                                    <td>{{$user->display_name}}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{$user->email}}
                                        @if($user->email_verified)
                                            <i class="fa fa-check-circle-o m--font-success"></i>
                                        @else
                                            <i class="fa fa-check-circle-o m--font-metal"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>mobile_number:</td>
                                    <td>{{$user->mobile_number}}
                                        @if($user->mobile_confirmed)
                                            <i class="fa fa-check-circle-o m--font-success"></i>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>birthday:</td>
                                    <td>{{$user->birthday ? $user->birthday->toFormattedDateString():'-'}}</td>
                                </tr>
                                <tr>
                                    <td>avatar:</td>
                                    <td>
                                        @if($user->avatar)
                                            <img src="{{$user->avatar->url}}" alt="" width="200px" height="200px">
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @if($user->social_link)
                                    <tr>
                                        <td>social_link:</td>
                                        <td>
                                            {{$user->social_link}}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td>description:</td>
                                    <td>
                                        {{$user->description}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>country:</td>
                                    <td>
                                        {{$user->country}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>id_number:</td>
                                    <td>
                                        {{$user->id_number}}
                                    </td>
                                </tr>
                                <tr class="m-table__row--brand">
                                    <td colspan="2" align="center"><strong>Address</strong></td>
                                </tr>
                                <tr>
                                    <td>Address:</td>
                                    <td>{{$user->p_address}}</td>
                                </tr>
                                <tr>
                                    <td>City:</td>
                                    <td>{{$user->p_city}}</td>
                                </tr>
                                <tr>
                                    <td>Country:</td>
                                    <td>{{$user->p_country}}</td>
                                </tr>
                                <tr>
                                    <td>Postcode:</td>
                                    <td>{{$user->p_postcode}}</td>
                                </tr>

                                {{--<tr>--}}
                                {{--<td>last_visit:</td>--}}
                                {{--<td>--}}
                                {{--{{$user->last_visit}}--}}
                                {{--</td>--}}
                                {{--</tr>--}}

                            </table>

                            <hr>
                            <h5>User rights</h5>
                            <a href="{{route('control:users.admin_toggle', $user->id)}}"
                               class="btn btn-{{$user->hasRole('admin') ?'primary' :'metal'}}">Admin</a>
                            <a href="#"
                               class="btn btn-{{$user->hasRole('user') ?'primary' :'metal'}}">User</a>
                            <a href="#"
                               class="btn btn-{{$user->hasRole('partner') ?'primary' :'metal'}}">Partner</a>
                            <hr>

                            <form action="{{route('control:users.update', $user->id)}}" method="post">
                                {{csrf_field()}}
                                <select name="trusted" id="input_trusted">
                                    <option value="false" {{$user->trusted ? '' : 'selected'}}>NOT Trusted</option>
                                    <option value="true" {{$user->trusted ? 'selected' : ''}}>Trusted</option>
                                </select>
                                <button>Change</button>
                            </form>
                            <div role="alert" class="alert m-alert m-alert--default">
                                Туры доверенного пользователя автоматически становятся "Проверенными"
                            </div>
                        </div>
                    </div>
                </div>

                @if($user->hasRole('partner'))
                    @if($user->partner)
                        <div class="col-xl-6 col-lg-6">
                            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">

                                <div class="m-portlet__head">
                                    <div class="m-portlet__head-caption">
                                        <div class="m-portlet__head-title">
                                            <h3 class="m-portlet__head-text">
                                                Partner
                                                #{{$partner->id}}
                                                {{$partner->name or '-'}}
                                                <small> {{$partner->llc or '-'}}</small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-portlet__body">

                                    <table class="table m-table">
                                        <tr class="m-table__row--brand">
                                            <td colspan="2" align="center">Owner</td>
                                        </tr>
                                        <tr>
                                            <td>First name:</td>
                                            <td>{{$partner->first_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Last name:</td>
                                            <td>{{$partner->last_name}}</td>
                                        </tr>
                                        <tr class="m-table__row--brand">
                                            <td colspan="2" align="center">Company</td>
                                        </tr>
                                        <tr>
                                            <td>LLC:</td>
                                            <td>{{$partner->llc}}</td>
                                        </tr>
                                        <tr>
                                            <td>Name:</td>
                                            <td>{{$partner->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Reg number:</td>
                                            <td>{{$partner->number}}</td>
                                        </tr>
                                        <tr>
                                            <td>VAT:</td>
                                            <td>
                                                @if($partner->vat)
                                                    <i class="fa fa-check-circle-o m--font-success"></i>
                                                @else
                                                    {{--<i class="fa fa-check-circle-o m--font-metal"></i>--}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="m-table__row--brand">
                                            <td colspan="2" align="center">Contacts</td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>{{$partner->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone:</td>
                                            <td>{{$partner->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>FAX:</td>
                                            <td>{{$partner->fax}}</td>
                                        </tr>
                                        <tr>
                                            <td>Website URL:</td>
                                            <td>{{$partner->website}}</td>
                                        </tr>
                                        <tr class="m-table__row--brand">
                                            <td colspan="2" align="center"><strong>Address</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Address:</td>
                                            <td>{{$partner->address1}}</td>
                                        </tr>
                                        <tr>
                                            <td>City:</td>
                                            <td>{{$partner->city}}</td>
                                        </tr>
                                        <tr>
                                            <td>Country:</td>
                                            <td>{{$partner->country}}</td>
                                        </tr>
                                        <tr>
                                            <td>Postcode:</td>
                                            <td>{{$partner->postcode}}</td>
                                        </tr>
                                    </table>

                                    <hr>
                                    <table class="table m-table">
                                        <tr class="m-table__row--brand">
                                            <td colspan="2" align="center"><strong>Billing</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Bank Name:</td>
                                            <td>{{$partner->bank_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Account Number:</td>
                                            <td>{{$partner->bank_number}}</td>
                                        </tr>
                                        <tr>
                                            <td>Bank Code:</td>
                                            <td>{{$partner->bank_code}}</td>
                                        </tr>
                                        <tr>
                                            <td>Beneficiary:</td>
                                            <td>{{$partner->bank_recipient}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address 1:</td>
                                            <td>{{$partner->bank_address1}}</td>
                                        </tr>
                                        <tr>
                                            <td>Address 2:</td>
                                            <td>{{$partner->bank_address2}}</td>
                                        </tr>
                                        <tr>
                                            <td>City:</td>
                                            <td>{{$partner->bank_city}}</td>
                                        </tr>
                                        <tr>
                                            <td>Country:</td>
                                            <td>{{$partner->bank_country}}</td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-xl-6 col-lg-6">partner error</div>
                    @endif
                @endif
            </div>

        </div>
    </div>
@endsection