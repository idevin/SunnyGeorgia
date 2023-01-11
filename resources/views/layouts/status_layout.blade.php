@switch($status)
    @case('created')
    <span class="m-badge m-badge--warning m-badge--wide">{{$status}}</span>
    @break
    @case('confirmed')
    <span class="m-badge m-badge--primary  m-badge--wide">{{$status}}</span>
    @break
    @case('canceled')
    <span class="m-badge m-badge--default  m-badge--wide">{{$status}}</span>
    @break
    @case('payed')
    <span class="m-badge m-badge--success  m-badge--wide">{{$status}}</span>
    @break
    @default
    <span class="m-badge m-badge--success  m-badge--wide">{{$status}}</span>
    @break
@endswitch   