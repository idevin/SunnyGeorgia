<div class="p-reviews">
    <div class="p-reviews__header">
        {{trans('reviews.Reviews')}} ({{$reviews->count()}})
        <div class="p-top__rating">
            @php
                $rating = $avgRating
            @endphp
            @foreach(range(1,5) as $i)
                <div class="p-top__rating-item">
                    @if($rating >0)
                        @if($rating >0.5)
                            {{--целая звезда--}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="15.5px" height="14.5px">
                                <path fill-rule="evenodd"  stroke="rgb(255, 196, 17)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="rgb(255, 196, 17)"
                                      d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
                            </svg>
                        @else
                            {{--половина--}}
                            <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="15.5px" height="14.5px">
                                <path fill-rule="evenodd"  stroke="rgb(255, 196, 17)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                      d="M10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 Z"/>
                                <path fill-rule="evenodd"  fill="rgb(255, 196, 17)"
                                      d="M3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L7.251,11.204 L3.303,12.834 Z"/>
                            </svg>
                        @endif
                    @else
                        {{--пустая--}}
                        <svg
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="15.5px" height="14.5px">
                            <path fill-rule="evenodd"  stroke="rgb(255, 196, 17)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                  d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
                        </svg>
                    @endif
                </div>
                @php
                    $rating--
                @endphp
            @endforeach
            <div class="p-top__rating-number">{{$avgRating}}</div>
            <div class="p-top__review-count">({{trans('reviews.Average rating')}})</div>
        </div>
    </div>
    @foreach($reviews as $review)
        <div class="p-review">
            <div class="p-review__avatar">
                <img data-src="{{$review->avatar_url ?? $review->author->avatar->url}}"
                     alt="{{$review->author_name ?? $review->author->name}} avatar"
                     class="p-review__avatar-img lazyload"
                >
            </div>
            <div class="p-review__body">
                <div class="p-review__header">
                    <div class="p-review__rating">
                        @php
                            $rating = $review->rating
                        @endphp
                        @foreach(range(1,5) as $i)
                            <div class="p-top__rating-item">
                                @if($rating >0)
                                    @if($rating >0.5)
                                        {{--целая--}}
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             width="15.5px" height="14.5px">
                                            <path fill-rule="evenodd"  stroke="rgb(255, 196, 17)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="rgb(255, 196, 17)"
                                                  d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
                                        </svg>
                                    @else
                                        {{--половина--}}
                                        <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                width="15.5px" height="14.5px">
                                            <path fill-rule="evenodd"  stroke="rgb(255, 196, 17)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                                  d="M10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 Z"/>
                                            <path fill-rule="evenodd"  fill="rgb(255, 196, 17)"
                                                  d="M3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L7.251,11.204 L3.303,12.834 Z"/>
                                        </svg>
                                    @endif
                                @else
                                    {{--пустая--}}
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="15.5px" height="14.5px">
                                        <path fill-rule="evenodd"  stroke="rgb(255, 196, 17)" stroke-width="1px" stroke-linecap="butt" stroke-linejoin="miter" fill="none"
                                              d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
                                    </svg>
                                @endif
                            </div>
                            @php
                                $rating--
                            @endphp
                        @endforeach
                    </div>
                    <div class="p-review__author">
                        {{$review->author_name ?? $review->author->display_name ?? $review->author->first_name}}
                    </div>
                </div>
                <div class="p-review__details">
                    <span class="p-review__country">{{$review->author->country ?? $review->author_country}}</span>
                    <span class="p-review__date">{{$review->date ?? $review->updated_at}}</span>
                </div>
                <div class="p-review__text">
                    {{$review->body}}
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="p-paginator">
</div>
