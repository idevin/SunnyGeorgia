<div class="aside hidden-until-load" ref="aside">
  <shared-weather
    :place-data="{{$place}}"
  ></shared-weather>

  <div class="aside__block" ref="useful-links">
      <div class="useful-links">
          <div class="useful-links__title">
              Полезные ссылки:
          </div>
          <a href="{{route('excursions.index', ['place' => $place->id])}}" class="useful-links__item">{{trans('main.Excursions')}}
            <svg width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z" class=""></path>
              </svg>
          </a>
          <a href="{{route('tours.index', ['place' => $place->id])}}" class="useful-links__item">{{trans('main.Tours')}}
            <svg width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z" class=""></path>
              </svg>
          </a>
      </div>
  </div>
  <div class="" ref="useful-links-hover" v-show="usefulLinksHover">
    <div class="useful-links useful-links_hover">
        <a href="{{route('excursions.index', ['place' => $place->id])}}" class="useful-links__item">{{trans('main.Excursions')}}
        </a>
        <a href="{{route('tours.index', ['place' => $place->id])}}" class="useful-links__item">{{trans('main.Tours')}}
        </a>
        <svg class="useful-links_hover__arrow" width="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor" d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z" class=""></path>
        </svg>
    </div>
  </div>

  @foreach($asideData['tours'] as $item)
    @include('site.aside.tour_aside_item', $item)
  @endforeach

  @foreach($asideData['excursions'] as $item)
    @include('site.aside.excursion_aside_item', $item)
  @endforeach
</div>
