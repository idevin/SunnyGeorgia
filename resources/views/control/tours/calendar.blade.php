@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Календарь доступности туров для бронирования на для конкретной даты
                    </h3>
                </div>
                <div class="m-portlet__head-tools">
                    @include('control.tours.block_buttons')
                </div>
            </div>
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
                <form action="{{route('control:tours.accommodation.update_availability_form')}}" method="post">
                    {!! csrf_field() !!}
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    @php
                                        $prevMonth = (clone($date))->subMonth();
                                        $nextMonth = (clone($date))->addMonth();
                                    @endphp
                                    <a href="{{route('control:tours.calendar', [$tour->id, 'month' => $prevMonth->month, 'year' => $prevMonth->year])}}"
                                       class="btn btn-default"
                                    >
                                        <span>
                                            <i class="fa fa-angle-left"></i>
                                            @lang('date.months.'.$prevMonth->format('F'))
                                        </span>
                                    </a>
                                    {{$date->year}} @lang('date.months.'.$date->format('F'))
                                    <a href="{{route('control:tours.calendar', [$tour->id, 'month' => $nextMonth->month, 'year' => $nextMonth->year])}}"
                                       class="btn btn-default"
                                    >
                                        <span>
                                            @lang('date.months.'.$nextMonth->format('F'))
                                            <i class="fa fa-angle-right"></i>
                                        </span>
                                    </a>
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                @php
                                    $hotLinksDateTo = \Carbon\Carbon::now()->startOfMonth()->addMonths(6);
                                    $hotLinksDatePointer = \Carbon\Carbon::now()->startOfMonth()->subMonth();
                                @endphp
                                @for($hotLinksDatePointer; $hotLinksDateTo->diffInMonths($hotLinksDatePointer, true) > 0; $hotLinksDatePointer->addMonth())
                                    <li class="m-portlet__nav-item">
                                        @if($date->diffInMonths($hotLinksDatePointer) !== 0)
                                            <a href="{{route('control:tours.calendar', [$tour->id, 'month' => $hotLinksDatePointer->month, 'year' => $hotLinksDatePointer->year])}}">
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
                                    <th style="width: 40px; color: white; font-size: 10px; text-align: center"
                                        class="{{$dateCalendarFrom->dayOfWeek == 6 || $dateCalendarFrom->dayOfWeek == 0 ? 'm--bg-warning':'m--bg-primary'}} {{$dateCalendarFrom->isToday() ? 'm--bg-danger':''}} "
                                    >
                                        {{$dateCalendarFrom->day}}
                                        @lang('date.day_of_week.'.$dateCalendarFrom->dayOfWeek)
                                    </th>
                                @endfor
                            </tr>
                            @foreach($accommodations as $index => $item)
                                <tr>
                                    <td colspan="{{$amountDaysInMonth+1}}" align="center">
                                        <h4>{{$item->hotel}} {{$item->room}}</h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Доступное для бронирования
                                        <a href="#" class="btn btn-primary btn-xs"
                                          data-toggle="modal"
                                          data-accommodation-name="{{$item->hotel}} {{$item->room}}"
                                          data-accommodation-id="{{$item->id}}"
                                          data-target="#availability_modal"
                                        >
                                            <span><i class="fa fa-pencil-alt"></i></span>
                                        </a>
                                    </td>
                                    @php
                                        $dateCalendarFrom = (new \Carbon\Carbon($date))->startOfMonth();
                                        $dateCalendarTo = (new \Carbon\Carbon($date))->startOfMonth()->addMonth();
                                    @endphp
                                    @for($dateCalendarFrom->day = 1; $dateCalendarFrom->diffInDays($dateCalendarTo) > 0; $dateCalendarFrom->addDay())
                                        <td style="width: 40px; padding: 2px; text-align: center"
                                            class="{{!empty($availabilities[$item->id][$dateCalendarFrom->toDateString()]->amount) ? 'm--bg-success' : ''}}
                                            {{$dateCalendarFrom->isPast() && !$dateCalendarFrom->isToday() ? 'm--bg-fill-warning':''}}"
                                        >
                                            @if($dateCalendarFrom->isPast() && !$dateCalendarFrom->isToday())
                                                <p></p>
                                                <p>{{$availabilities[$item->id][$dateCalendarFrom->toDateString()]->amount ?? '0'}}</p>
                                            @else
                                                <input class="scheduler scheduler_input scheduler_input_amount"
                                                       style="width: 35px; height: 35px;"
                                                       type="number" min="0" step="1" width="35" height="35"
                                                       value="{{$availabilities[$item->id][$dateCalendarFrom->toDateString()]->amount ?? '0'}}"
                                                       name="availability[{{$item->id}}][{{$dateCalendarFrom->toDateString()}}]"
                                                >
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                            @if(count($accommodations) == 0)
                                <tr>
                                    <td colspan="{{$amountDaysInMonth+1}}" align="center">
                                        <h4>No available accommodations</h4>
                                        <a href="{{route('control:tours.accommodation', $tour->id)}}"
                                           class="btn btn-default">Add new accommodations</a>
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

    <div class="modal fade" id="availability_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('control:tours.accommodation.update_availability', $tour->id)}}"
                      class="m-form m-form--fit m-form--label-align-right"
                      method="post">
                    {!! csrf_field() !!}
                    {{--<input type="text" name="accommodation_id" hidden>--}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">
                            {{--Изменить доступное количество для размещения: <strong>---</strong>--}}
                            Изменить доступное количество для размещения
                        </h5>
                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                &times;
                            </span>
                        </a>
                    </div>
                    <div class="modal-body">

                        <div class="form-group m-form__group m--margin-top-10">
                            <div class="alert m-alert m-alert--default" role="alert">
                                Перед сохранением новых данных все предыдущие размещения будут сброшены
                            </div>
                        </div>
                        <div class="m-form__group form-group row">
                            <label for="" class="col-form-label col-lg-3 col-sm-12">
                                Размещения<br>
                                <a href="#"
                                   onclick="$(this).parent().parent().find('input').prop('checked',true); return false;">Выбрать
                                    все</a><br>
                                <a href="#"
                                   onclick="$(this).parent().parent().find('input').prop('checked',false);  return false;">Сбросить</a>

                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <div class="m-checkbox-list">
                                    @foreach($accommodations->sortBy('hotel') as $accomm)
                                        <label class="m-checkbox">
                                            <input type="checkbox" name="accommodations[]" value="{{$accomm->id}}"
                                            >
                                            {{$accomm->hotel}} {{$accomm->room}}
                                            <span></span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Период
                                <br>
                                <a href="#"
                                   onclick="$('input[name=date_from]').val(moment().format('DD-MM-Y'));
                                   $('input[name=date_to]').val(moment().add(1, 'M').format('DD-MM-Y'));return false;">1
                                    месяц</a><br>
                                <a href="#"
                                   onclick="$('input[name=date_from]').val(moment().format('DD-MM-Y'));
                                   $('input[name=date_to]').val(moment().add(2, 'M').format('DD-MM-Y'));return false;">2
                                    месяц</a><br>
                                <a href="#"
                                   onclick="$('input[name=date_from]').val(moment().format('DD-MM-Y'));
                                   $('input[name=date_to]').val(moment().add(3, 'M').format('DD-MM-Y'));return false;">3
                                    месяц</a><br>
                                <a href="#"
                                   onclick="$('input[name=date_from]').val(moment().format('DD-MM-Y'));
                                   $('input[name=date_to]').val(moment().add(5, 'M').format('DD-MM-Y'));return false;">5
                                    месяц</a><br>
                                <a href="#"
                                   onclick="$('input[name=date_from]').val(moment().format('DD-MM-Y'));
                                   $('input[name=date_to]').val(moment().add(6, 'M').format('DD-MM-Y'));return false;">6
                                    месяц</a><br>
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input class="form-control datepicker" placeholder="Начальная дата" type="text"
                                       name="date_from" value="{{\Carbon\Carbon::now()->format('d-m-Y')}}" required>
                                -
                                <input class="form-control datepicker" placeholder="Конечная дата" type="text"
                                       name="date_to" required>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Дни недели
                                <br>
                                <a href="#"
                                   onclick="$(this).parent().parent().find('input').prop('checked',true); return false;">Выбрать
                                    все</a><br>
                                <a href="#"
                                   onclick="$(this).parent().parent().find('input').prop('checked',false); return false;">Сбросить</a>
                            </label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <table>
                                    <tr>
                                        @foreach(trans('date.day_of_week') as $d => $wk)
                                            <td><label for="input_week_day_{{$d}}">{{$wk}}<br>
                                                    <input type="checkbox" id="input_week_day_{{$d}}"
                                                           name="day_of_week[{{$d}}]"
                                                           checked>
                                                </label></td>
                                        @endforeach
                                    </tr>
                                </table>
                                <span class="m-form__help">Изменить только выбранные дни недели</span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Количество доступное для бронирования
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <input class="form-control"
                                       type="number" step="1" min="0"
                                       value="100"
                                       name="amount"
                                       placeholder="Amount" required>
                                <span class="m-form__help">Устанавливает доступное количество туров</span>

                            </div>
                        </div>
                        {{--<div class="form-group m-form__group row">--}}
                        {{--<label class="col-form-label col-lg-4 col-sm-12">--}}
                        {{--Special price for selected dates--}}
                        {{--</label>--}}
                        {{--<div class="col-lg-8 col-md-9 col-sm-12">--}}
                        {{--<input class="form-control"--}}
                        {{--type="number" step="1" min="0"--}}
                        {{--value=""--}}
                        {{--name="price"--}}
                        {{--placeholder="Price">--}}
                        {{--<span class="m-form__help">--}}
                        {{--If empty default price will be setted.--}}
                        {{--</span>--}}

                        {{--</div>--}}

                        {{--</div>--}}
                        {{--<div class="form-group m-form__group row">--}}
                        {{--<label class="col-form-label col-lg-4 col-sm-12">--}}
                        {{--Discount--}}
                        {{--</label>--}}
                        {{--<div class="col-lg-8 col-md-9 col-sm-12">--}}

                        {{--<div class="input-group m-input-group">--}}
                        {{--<span class="input-group-addon" id="basic-addon1">--}}
                        {{--%--}}
                        {{--</span>--}}
                        {{--<input class="form-control"--}}
                        {{--type="number" min="0"--}}
                        {{--value="0"--}}
                        {{--name="discount"--}}
                        {{--placeholder="Discount">--}}

                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group m-form__group m--margin-top-10">
                            <div class="alert m-alert m-alert--default" role="alert" id="price_info"
                                 style="display: none">
                                Accommodation available amount will be set up or overwrite for every day between next
                                dates
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{trans('main.Cancel')}}
                        </button>
                        <button type="submit" class="btn btn-primary">{{trans('main.Save changes')}}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
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
                var accommodation_name = button.data('accommodation-name'); // Extract info from data-* attributes
                var accommodation_id = button.data('accommodation-id'); // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                // modal.find('#modalTitle strong').text(accommodation_name);
                // modal.find('input[name="accommodation_id"]').val(accommodation_id);
                console.log(accommodation_id);
                modal.find('input[name="accommodations[]"]').prop('checked', false);
                modal.find('input[name="accommodations[]"][value="' + accommodation_id + '"]').prop('checked', true);
                console.log(modal.find('input[name="accommodations[]"][value="' + accommodation_id + '"]'));

                // console.log(accommodation_id);
                // console.log($('input[name="accommodation_id"]').val());
                // var input_price = modal.find('.modal-body input[name="price"]');
                // var input_discount = modal.find('.modal-body input[name="discount"]');
                // var price_info = $('#price_info');
                // input_discount.on('change', function () {
                //     var price = input_price.val() - (input_price.val() * input_discount.val() * 0.01);
                //     price_info.text('Final price will be: ' + price);
                //     price_info.show();
                // })

            });
            $('.scheduler_input').on('change', function () {
                $('#notify_unsaved_changes').show();
            });
            $('input[type="reset"]').on('click', function () {
                $('#notify_unsaved_changes').hide();

            });

        });
    </script>
@endpush
