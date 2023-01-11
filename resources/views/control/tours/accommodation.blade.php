@extends('cabinet.layouts.app')

@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Размещения
                    </h3>
                </div>
                <div class="m-portlet__head-tools">
                   @include('control.tours.block_buttons')
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Доступные размещения и цены
                                {{--<small>--}}
                                {{--portlet sub title--}}
                                {{--</small>--}}
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <form action="{{route('control:tours.accommodation.update', $tour->id)}}" method="POST">
                        {!! csrf_field() !!}
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <th>
                                    <div class="py-2 text-right text-uppercase"><strong>Тип номера</strong></div>
                                    <div class="py-3 mb-1 text-right text-uppercase"><strong>Кол-во людей в номере</strong></div><hr>
                                    <div class="py-2 text-center text-uppercase"><strong>Название или Тип размещения</strong></div>
                                </th>
                                @foreach($rooms as $m => $room)
                                    <th width="120" @if($m % 2 == 0) style="background-color: #d9edf7;" @endif>
                                        <input class="form-control mr-1 px-1 mb-1" type="text" name="rooms[{{$m}}]" value="{{$room}}">
                                        <input class="form-control px-1"
                                               type="number" step="1" min="1"  max="6"
                                               name="acoms[{{$m}}][adults]"
                                               value="{{isset($acom->groupBy('room')[$room])? $acom->groupBy('room')[$room][0]->adults : $m+1}}">
                                        <hr>
                                        <div class="py-2">&nbsp;</div>
                                    </th>
                                @endforeach
                                <th width="120" class="text-center" style="vertical-align: middle; background-color: #fcf8e3;">
                                    <div class="text-uppercase"><strong>E<small>x</small>B price</strong></div>
                                </th>
                                <th width="120" class="text-center" style="vertical-align: middle; background-color: #fcf8c3;">
                                    <div class="text-uppercase"><strong>Child price</strong></div>
                                </th>
                                <th width="120" class="text-center" style="vertical-align: middle;">
                                    <div class="text-uppercase"><strong>Удалить размещение</strong></div>
                                </th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($hotels as $n => $hotel)
                                <tr>
                                    <td>
                                        <input class="form-control" type="text" name="hotels[{{$n}}]" value="{{$hotel}}">
                                    </td>
                                    @foreach($rooms as $m => $room)
                                        <td @if($m % 2 == 0) style="background-color: #d9edf7;" @endif>
                                            <input class="form-control"
                                                   name="acoms[{{$n}}][{{$m}}][price_adult]"
                                                   type="number"
                                                   step="0.01"
                                                   min="0"
                                                   value="{{(isset($acom->groupBy('hotel')[$hotel]) && isset($acom->groupBy('hotel')[$hotel]->groupBy('room')[$room]))? $acom->groupBy('hotel')[$hotel]->groupBy('room')[$room][0]->price_adult : null}}">

                                            <input type="hidden" name="acoms[{{$n}}][{{$m}}][id]"
                                                   value="{{(isset($acom->groupBy('hotel')[$hotel]) && isset($acom->groupBy('hotel')[$hotel]->groupBy('room')[$room]))? $acom->groupBy('hotel')[$hotel]->groupBy('room')[$room][0]->id : null}}">
                                        </td>
                                    @endforeach
                                    <td style="background-color: #fcf8e3;">
                                        <input class="form-control"
                                                name="acoms[{{$n}}][price_additional]"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                value="{{isset($acom->groupBy('hotel')[$hotel])? $acom->groupBy('hotel')[$hotel][0]->price_additional : null}}">
                                    </td>
                                    <td style="background-color: #fcf8c3;">
                                        <input class="form-control"
                                                name="acoms[{{$n}}][price_kid]"
                                                type="number"
                                                step="0.01"
                                                min="0"
                                                value="{{isset($acom->groupBy('hotel')[$hotel])? $acom->groupBy('hotel')[$hotel][0]->price_kid : null}}">
                                    </td>
                                    <td>
                                        <a href="{{route('control:tours.accommodation.delete', [$tour->id, $hotel])}}"
                                           class="btn btn-danger btn-xs"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{route('control:tours.accommodation', $tour->id)}}" class="btn btn-default">{{trans('main.Cancel')}}</a>
                        <button type="submit" class="btn btn-primary">{{trans('main.Save')}}</button>
                    </form>
                </div>











{{--
                <div class="m-portlet__body">
                    <table class="table">
                        <tr>
                            <th>Отель</th>
                            <th>Комната</th>
                            <th align="right">Взрослые</th>
                            <th align="right">Дети</th>
                            <th align="right">Доп. кровати</th>
                            <th align="right">Цена Взрослые</th>
                            <th align="right">Цена дети</th>
                            <th align="right">Цена доп.кровати</th>
                            <th>Валюта</th>
                            --}}{{--<th align="right">Published</th>--}}{{--
                            <th></th>
                        </tr>
                        @foreach($acom as $item)
                            <tr>
                                <td>{{$item->hotel}}</td>
                                <td>{{$item->room}}</td>
                                <td>{{$item->adults or null}}</td>
                                <td>{{$item->kids or null}}</td>
                                <td>{{$item->add_beds or null}}</td>
                                <td align="right">
                                    {{ currency_format($item->price_adult ?:0, $tour->currency_code)}}
                                </td>
                                <td align="right">
                                    {{ currency_format($item->price_kid ?:0, $tour->currency_code)}}
                                </td>
                                <td align="right">
                                    {{ currency_format($item->price_additional ?:0, $tour->currency_code)}}
                                </td>
                                <td>
                                    {{$tour->currency_code}}
                                </td>
                                --}}{{--<td>--}}{{--
                                --}}{{--<input data-switch="true" type="checkbox"--}}{{--
                                --}}{{--{{$item->published ? 'checked="checked"':''}} data-on-text="Published"--}}{{--
                                --}}{{--data-handle-width="50" data-off-text="Draft" data-on-color="success">--}}{{--
                                --}}{{--</td>--}}{{--
                                <td>
                                    <a href="{{route('control:tours.accommodation.delete', [$tour->id, $item->id])}}"><i
                                                class="fa fa-trash"></i></a>
                                    --}}{{--<a href="">Edit</a>--}}{{--
                                </td>
                            </tr>
                        @endforeach
                        @if(count($acom) == 0)
                            <tr>
                                <td colspan="8" align="center">
                                    Резмещения не добавлены
                                </td>
                            </tr>
                        @endif
                    </table>

                </div>--}}
            </div>
{{--            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Добавить размещение
                                --}}{{--<small>--}}{{--
                                --}}{{--portlet sub title--}}{{--
                                --}}{{--</small>--}}{{--
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <form action="{{route('control:tours.accommodation.post', $tour->id)}}" method="post">
                        {!! csrf_field() !!}
                        <table class="table">
                            <tr>
                                <th>Отель</th>
                                <th>Комната</th>
                                <th align="right">Взрослые</th>
                                <th align="right">Дети</th>
                                <th align="right">Доп. кровати</th>
                                <th align="right">Цена Взрослые<span style="color: red;">*</span></th>
                                <th align="right">Цена дети</th>
                                <th align="right">Цена доп.кровати</th>
                                <th>Валюта</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><textarea class="form-control m-input"
                                              name="acom[1][hotel]" type="text" placeholder="hotel"
                                              required>{{old('acom.1.hotel')}}</textarea></td>
                                <td><textarea class="form-control m-input"
                                              name="acom[1][room]" type="text" placeholder="room"
                                              required>{{old('acom.1.room')}}</textarea></td>
                                <td><input name="acom[1][adults]" type="number" step="1" min="0"
                                           style="width: 50px"
                                           value="{{old('acom.1.adults', 2)}}" placeholder="0" required></td>
                                <td><input name="acom[1][kids]" type="number" step="1" value="{{old('acom.1.kids', 0)}}"
                                           style="width: 50px"
                                           placeholder="0" required></td>
                                <td><input name="acom[1][add_beds]" type="number" step="1" min="0"
                                           value="{{old('acom.1.add_beds', 0)}}"
                                           style="width: 50px"
                                           placeholder="0"></td>
                                <td><input name="acom[1][price_adult]" type="number" step="0.01" min="0"
                                           style="width: 50px"
                                           value="{{old('acom.1.price_adult', 0)}}" placeholder="0.00" required></td>
                                <td><input name="acom[1][price_kid]" type="number" step="0.01" min="0"
                                           style="width: 50px"
                                           value="{{old('acom.1.price_kid', 0)}}" placeholder="0.00" required></td>
                                <td><input name="acom[1][price_additional]" type="number" step="0.01" min="0"
                                           style="width: 50px"
                                           value="{{old('acom.1.price_additional', 0)}}" placeholder="0.00" required>
                                </td>
                                <td>
                                    {{$tour->currency_code}}
                                </td>

                                <td><a href="#" onclick="$(this).parent().parent().remove();return false;"
                                       class=""><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @foreach(old('acom',[]) as $key => $values)
                                @if($key > 1)
                                    <tr>
                                        <td><textarea class="form-control m-input"
                                                      name="acom[{{$key}}][hotel]" type="text" placeholder="Hotel"
                                                      style="width: 100%"
                                                      required>{{old('acom.'.$key.'.hotel')}}</textarea></td>
                                        <td><textarea class="form-control m-input"
                                                      name="acom[{{$key}}][room]" type="text" placeholder="Room"
                                                      style="width: 100%"

                                                      required>{{old('acom.'.$key.'.room')}}</textarea></td>
                                        <td><input name="acom[{{$key}}][adults]" type="number" step="1" min="0"
                                                   style="width: 50px"
                                                   value="{{old('acom.'.$key.'.adults', 0)}}" placeholder="0" required>
                                        </td>
                                        <td><input name="acom[{{$key}}][kids]" type="number" step="1" min="0"
                                                   value="{{old('acom.'.$key.'.kids', 0)}}"
                                                   style="width: 50px"
                                                   placeholder="0"></td>
                                        <td><input name="acom[{{$key}}][add_beds]" type="number" step="1" min="0"
                                                   value="{{old('acom.'.$key.'.add_beds', 0)}}"
                                                   style="width: 50px"
                                                   placeholder=""></td>
                                        <td><input name="acom[{{$key}}][price_adult]" type="number" step="0.01" min="0"
                                                   style="width: 50px"
                                                   value="{{old('acom.'.$key.'.price_adult', 0)}}" placeholder="0.00">
                                        </td>
                                        <td><input name="acom[{{$key}}][price_kid]" type="number" step="0.01" min="0"
                                                   style="width: 50px"
                                                   value="{{old('acom.'.$key.'.price_kid', 0)}}" placeholder="0.00">
                                        </td>
                                        <td><input name="acom[{{$key}}][price_additional]" type="number" step="0.01"
                                                   min="0"
                                                   style="width: 50px"
                                                   value="{{old('acom.'.$key.'.price_additional', 0)}}"
                                                   placeholder="0.00">
                                        </td>
                                        <td>
                                            {{$tour->currency_code}}
                                        </td>

                                        <td><a href="#" onclick="$(this).parent().parent().remove();return false;"
                                               class=""><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                        <button type="button" class="btn btn-success" onclick="addRow(this);"><i class="fa fa-plus"></i>
                        </button>
                        <br>
                        <button type="reset" class="btn btn-default">{{trans('main.Cancel')}}</button>
                        <button type="submit" class="btn btn-primary">{{trans('main.Save')}}</button>
                    </form>
                </div>
            </div>
        </div>--}}
    </div>
@endsection

@push('scripts')
    <script>


        function addRow(el) {
            var form = $(el).parent().find('table');
            var row = $(el).parent().find('tr:last-child').clone();

            var index = form.find('tr').length;
            console.log(index);
            row.find('input').each(function () {
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[[0-9]+\]/), "[" + index + "]"));
            });
            row.find('select').each(function () {
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[[0-9]+\]/), "[" + index + "]"));
            });
            row.find('textarea').each(function () {
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[[0-9]+\]/), "[" + index + "]"));
            });

            form.append(row);
            console.log(row);
        }

        $("[data-switch=true]").bootstrapSwitch()
    </script>
@endpush
