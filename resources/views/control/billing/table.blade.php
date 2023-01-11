<table class="table table-responsive">
    {{--№ заказа--}}
    {{--Дата заказа:--}}
    {{--Дата начала оказания Услуги--}}
    {{--Клиент (емаил)--}}
    {{--Название Услуги--}}
    {{--Оператор--}}
    {{--Сумма заказа--}}
    {{--Предоплата %--}}
    {{--Сумма предоплаты--}}
    {{--Доплата %--}}
    {{--Сумма доплаты на месте--}}
    {{--С какого числа можо зачислять $ оператору--}}
    <thead>
    <tr>
        <th>order id</th>
        <th>Created</th>
        <th>Дата начала оказания Услуги</th>
        <th>Customer</th>
        <th>Service</th>
        <th>Partner</th>
        <th>Total cost</th>
        <th>Prepay %</th>
        <th>Prepay</th>
        <th>Postpay %</th>
        <th>Postpay</th>
        <th>С какого числа можо зачислять $ оператору</th>
    </tr>
    </thead>

    <tbody>
    @foreach($orders as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->date_in->toDateString()}}
                @if($item->date_time_in){{$item->date_time_in}}@endif
            </td>
            <td>
                @if($item->customer)
                    {{$item->customer->email}}
                @endif
            </td>
            <td>
                @if($item instanceof \App\Models\Tours\TourBooking)
                    <a href="{{route('control:tours.booking.view', $item->id)}}">#{{$item->id}}
                        Tour Booking</a>
                @elseif($item instanceof \App\Models\Excursions\ExcursionBooking)
                    <a href="{{route('control:excursions.booking.view', $item->id)}}">#{{$item->id}}
                        Excursion Booking</a>
                @endif
            </td>
            <td>

                @php
                    $partner = null;
                    if($item instanceof \App\Models\Tours\TourBooking){
                        $partner = $item->tour->partner;
                    }
                    elseif($item instanceof \App\Models\Excursions\ExcursionBooking)
                    {
                        $partner = $item->excursion->partner;
                    }
                @endphp
                @if($partner)
                    #{{$partner->id}} <strong>{{$partner->llc}}</strong>
                @endif

            </td>
            <td class="text-right">{{$item->total}}&nbsp;{{$item->currency_code}}</td>
            <td>{{number_format($item->prepay / $item->total * 100, 0)}}%</td>
            <td class="text-right">{{$item->prepay}}&nbsp;{{$item->currency_code}}
                <ul>
                    @foreach($item->payments as $pay)
                        @if($pay->status == 'payed')
                            <li style="border: 1px solid grey; background-color: lavender; padding: 5px; margin: 2px">{{$pay->system}} {{number_format($pay->amount/ 100, 2)}} {{$pay->currency_code}} {{$pay->created_at}}</li>
                        @endif
                    @endforeach
                </ul>
            </td>
            <td>{{number_format(($item->total - $item->prepay) / $item->total * 100, 0)}}%</td>
            <td class="text-right">{{$item->total - $item->prepay}}&nbsp;{{$item->currency_code}}</td>
            <td>{{$item->date_in->addDays(1)->toDateString()}}</td>

        </tr>
    @endforeach
    </tbody>
</table>
