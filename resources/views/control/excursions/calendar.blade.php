@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Календарь доступности экскурсий для бронирования
                    </h3>

                </div>
                <div class="m-portlet__head-tools">
                   @include('control.excursions.block_buttons', ['page' => 'calendar'])
                </div>
            </div>
            <a href="#" class="btn btn-primary btn-xs"
               data-toggle="modal"
               data-target="#availability_modal"><span><i class="fa fa-pencil-alt"></i></span>
            </a>
            <div class="alert alert-warning" role="alert" style="display: none" id="notify_unsaved_changes">
                <strong>
                    Warning!
                </strong>
                Unsaved changes!
            </div>
        </div>

        <!-- END: Subheader -->
        <div class="m-content">

            <div class="m-portlet m-portlet--mobile">
                <form action="{{route('control:excursions.availability.update_form', $excursion->id)}}"
                      method="post">
                    {!! csrf_field() !!}

                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                             @php
                                 $prevMonth = (clone($date))->subMonth();
                                 $nextMonth = (clone($date))->addMonth();
                             @endphp
                            <a href="{{route('control:excursions.calendar', [$excursion->id, 'month' => $prevMonth->month, 'year' => $prevMonth->year])}}"
                               class="btn btn-default">
                                    <span>
                                       <i class="fa fa-angle-left"></i>
                                        <span>
                                          @lang('date.months.'.$prevMonth->format('F'))
                                        </span>
                                    </span>
                                </a>
                            <div class="m-portlet__head-title" style="margin: 0 10px">

                                <h3 class="m-portlet__head-text">
                                    {{$date->year}} @lang('date.months.'.$date->format('F'))
                                </h3>

                            </div>
                             <a href="{{route('control:excursions.calendar', [$excursion->id, 'month' => $nextMonth->month, 'year' => $nextMonth->year])}}"
                                class="btn btn-default">
                                    <span>
                                        <span>
                                            @lang('date.months.'.$nextMonth->format('F'))
                                        </span>
                                        <i class="fa fa-angle-right"></i>
                                    </span>
                                </a>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                @php
                                    $hotLinksDateTo = \Carbon\Carbon::now()->startOfMonth()->addMonths(6);
                                    $hotLinksDatePointer = \Carbon\Carbon::now()->startOfMonth()->subMonth();
                                @endphp
                                @for($hotLinksDatePointer; $hotLinksDateTo->diffInMonths($hotLinksDatePointer, true) > 0; $hotLinksDatePointer->addMonth())
                                    <li class="m-portlet__nav-item">
                                        {{--                                                {{$date->diffInMonths($hotLinksDatePointer)}}--}}
                                        {{--{{$date}}--}}
                                        {{--                                                {{$hotLinksDatePointer}}--}}
                                        @if($date->diffInMonths($hotLinksDatePointer) !== 0)
                                            <a href="{{route('control:excursions.calendar', [$excursion->id, 'month' => $hotLinksDatePointer->month, 'year' => $hotLinksDatePointer->year])}}">
                                                {{$hotLinksDatePointer->year}} @lang('date.months.'.$hotLinksDatePointer->format('F'))
                                            </a>
                                        @else
                                            {{$hotLinksDatePointer->year}} @lang('date.months.'.$hotLinksDatePointer->format('F'))
                                        @endif
                                    </li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive" style="overflow: scroll">
                        <table class="table table-bordered table-responsive">
                            <tr>
                                <th style="width: 200px"></th>
                                @php
                                    $dateCalendarFrom = (new \Carbon\Carbon($date))->startOfMonth();
                                          $dateCalendarTo = (new \Carbon\Carbon($date))->startOfMonth()->addMonth();
                                @endphp


                                @for($dateCalendarFrom->day = 1; $dateCalendarFrom->diffInDays($dateCalendarTo) > 0; $dateCalendarFrom->addDay())

                                    <th
                                            style="width: 40px; color: white; font-size: 10px; text-align: center"
                                            class="{{$dateCalendarFrom->dayOfWeek == 6 || $dateCalendarFrom->dayOfWeek == 0 ? 'm--bg-warning':'m--bg-primary'}} {{$dateCalendarFrom->isToday() ? 'm--bg-danger':''}} "
                                            bgcolor=""
                                    >
                                        {{$dateCalendarFrom->day}}
                                        @lang('date.day_of_week.'.$dateCalendarFrom->dayOfWeek)
                                    </th>
                                @endfor
                            </tr>
                            @foreach($availabilities as $time => $availability)
                                <tr>
                                    <td colspan="{{$amountDaysInMonth+1}}" align="center">
                                        <h4>{{$time}}</h4>
                                        <a href="#" class="btn btn-primary btn-xs"
                                           data-toggle="modal"
                                           data-target="#availability_modal"
                                        >
                                            <span><i class="fa fa-pencil-alt"></i></span>
                                        </a>
                                        <a href="{{route('control:excursions.availabilities.delete', [$excursion->id, 'time' => $time])}}"
                                           class="btn btn-danger btn-xs"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    @php
                                        $dateCalendarFrom = (new \Carbon\Carbon($date))->startOfMonth();
                                        $dateCalendarTo = (new \Carbon\Carbon($date))->startOfMonth()->addMonth();
                                    @endphp
                                    @for($dateCalendarFrom->day = 1; $dateCalendarFrom->diffInDays($dateCalendarTo) > 0; $dateCalendarFrom->addDay())
                                        <td style="width: 40px; padding: 2px; text-align: center"
                                            class="{{!empty($availability[$dateCalendarFrom->toDateString()]->amount) ? 'm--bg-success' : ''}}
                                            {{$dateCalendarFrom->isPast() && !$dateCalendarFrom->isToday() ? 'm--bg-fill-warning':''}}"
                                        >
                                            @if($dateCalendarFrom->isPast() && !$dateCalendarFrom->isToday())
                                                <p></p>
                                                <p>{{$availability[$dateCalendarFrom->toDateString()]->amount ?? '0'}}</p>
                                            @else
                                                <input class="scheduler scheduler_input scheduler_input_amount"
                                                       type="number" min="0" step="1" width="35" height="35"
                                                       value="{{$availability[$dateCalendarFrom->toDateString()]->amount ?? '0'}}"
                                                       name="availability[{{$time}}][{{$dateCalendarFrom->toDateString()}}]"
                                                       style="width: 35px; height: 35px;"
                                                >
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                            @if(count($times) == 0)
                                <tr>
                                    <td colspan="{{$amountDaysInMonth+1}}"
                                        align="center">
                                        <h4>No available times</h4>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                    <div class="m-portlet__foot">
                        <button type="reset" class="btn btn-lg btn-default">{{trans('main.Cancel')}}</button>
                        <button type="submit" class="btn btn-lg btn-primary">{{trans('main.Save changes')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('control.excursions.calendar_modal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true
            });
            $('#availability_modal').on('shown.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal

            });
            $('.scheduler_input').on('change', function () {
                $('#notify_unsaved_changes').show();
            });
            $('input[type="reset"]').on('click', function () {
                $('#notify_unsaved_changes').hide();

            });
            $('#addTimeButton').on('click', function (event) {
                var template = "<div class='form-group'><input type='time' name='times[]' class='form-control select-times' required></div>";
                $(this).parent().prepend(template);
            });

        });
    </script>
@endpush
