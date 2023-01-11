<div class="modal fade" id="availability_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('control:excursions.availability.update', $excursion->id)}}"
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
                            Форма изменяет только выбранные даты и дни недели. Дни которые не попадают в период, не
                            изменяются.
                            Чтобы сбросить доступное количество экскурсий на 0, укажите число 0 в доступное количество и
                            выберите период.
                            {{--Количество доступного размещения в период:--}}
                            {{--Accommodation available amount will be set up for every day between next dates--}}
                        </div>
                    </div>
                    <div class="m-form__group form-group row">
                        <label for="" class="col-form-label col-lg-3 col-sm-12">
                            Время начала<br>
                            <a href="#"
                               onclick="$(this).parent().parent().find('input').prop('checked',true); return false;">Выбрать
                                все</a><br>
                            <a href="#"
                               onclick="$(this).parent().parent().find('input').prop('checked',false);  return false;">Сбросить</a>

                        </label>
                        <div class="col-lg-9 col-md-9 col-sm-12">
                            <div class="m-checkbox-list">
                                @foreach($times as $time)
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="times[]" value="{{$time}}"
                                        >
                                        {{$time}}
                                        <span></span>
                                    </label>
                                @endforeach
                                <button id="addTimeButton" type="button" class="btn-primary btn-xs">+</button>
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
                            <span class="m-form__help">Устанавливает доступное количество экскурсий</span>

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
