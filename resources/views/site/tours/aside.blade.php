<div class="aside hidden-until-load" ref="aside">

    <shared-weather
        :place-data="{{$place}}"
    ></shared-weather>
    {{--<shared-map v-if="domLoaded"--}}
    {{--            :place-data="{{json_encode($place)}}"--}}
    {{--></shared-map>--}}
    @foreach($asideData['tours'] as $item)
            @include('site.aside.tour_aside_item', $item)
    @endforeach

</div>