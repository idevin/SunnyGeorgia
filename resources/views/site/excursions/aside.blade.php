<div class="aside hidden-until-load" ref="aside">

<shared-weather
                :place-data="{{json_encode($excursion->place)}}"
></shared-weather>
{{--<shared-map v-if="domLoaded"--}}
{{--            :place-data="{{json_encode($place)}}"--}}
{{--></shared-map>--}}
@foreach($asideData['excursions'] as $item)
    @include('site.aside.excursion_aside_item', $item)
@endforeach

</div>