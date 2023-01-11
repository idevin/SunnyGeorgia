<search-form inline-template>
    <header>

        <div class="headerBackgroundItem show"></div>
        <div class="headerBackgroundItem excursions" :class="{'show':component === 'excursions'}"></div>


        <div class="search-block">
            <div class="search-block__nav">
                <div
                        @click="component = 'excursions'"
                        class="search-block__nav-item"
                        :class="{'search-block__nav-item_active': component === 'excursions'}"
                >{{trans('main.Excursions')}}</div>
                <div
                        @click="component = 'tours'"
                        :class="{'search-block__nav-item_active': component === 'tours'}"
                        class="search-block__nav-item"
                >{{trans('main.Tours')}}</div>
            </div>
            <div class="search-block__forms">
                <transition name="fade" mode="out-in">
                    <search-tours-form
                            inline-template
                            v-if="component === 'tours'"
                            :action-url="'{{route('tours.index')}}'"
                    >
                        <div class="search-block__forms-item" key="tours">
                            <div class="search-block__forms-item-select">
                                <div class="search-block__forms-item-content"
                                     @click="openSelect = !openSelect"
                                >
                                    <span v-text="selectDaysText ? selectDaysText : '{{trans('searchForm.Tour duration')}}'"></span>
                                    <svg class="angle" width="10" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                              d="M151.5 347.8L3.5 201c-4.7-4.7-4.7-12.3 0-17l19.8-19.8c4.7-4.7 12.3-4.7 17 0L160 282.7l119.7-118.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17l-148 146.8c-4.7 4.7-12.3 4.7-17 0z"></path>
                                    </svg>
                                </div>
                                <transition name="fade" mode="out-in">
                                    <div v-show="openSelect"
                                         class="search-block__drop-down"
                                         style="display: none"
                                         v-click-outside="closeSelect"
                                    >
                                        <ul>
                                            <li><a @click.prevent="selectDays($event, 0)"
                                                   href="">{{trans('searchForm.Show all')}}</a></li>
                                            <li><a @click.prevent="selectDays($event, 1,4)"
                                                   href="">1-4 {{trans_choice('searchForm.days', 4)}}</a>
                                            </li>
                                            <li><a @click.prevent="selectDays($event, 5,9)"
                                                   href="">5-9 {{trans_choice('searchForm.days', 9)}}</a>
                                            </li>
                                            <li><a @click.prevent="selectDays($event, 10)"
                                                   href="">10+ {{trans_choice('searchForm.days', 10)}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                </transition>
                            </div>
                            <div class="search-block__forms-item-date">
                                <div class="search-block__forms-item-content">
                                    <i class="icon-calendar calendar"></i>
                                    <v-date-picker
                                            is-double-paned
                                            :show-day-popover="false"
                                            mode='range'
                                            :min-date='new Date()'
                                            v-model='selectedDate'
                                            :input-props='{placeholder: "{{trans('main.Date interval')}}",readonly:true,style:"color:#000 !important"}'
                                    >
                                    </v-date-picker>
                                </div>
                            </div>
                            <div class="search-block__forms-item-submit" @click="submit">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="15px" height="14px">
                                    <path fill-rule="evenodd" fill="rgb(0, 0, 0)"
                                          d="M14.634,12.162 L11.749,9.277 C12.445,8.273 12.792,7.155 12.792,5.921 C12.792,5.119 12.637,4.353 12.325,3.621 C12.015,2.890 11.594,2.260 11.064,1.729 C10.534,1.199 9.904,0.779 9.172,0.467 C8.440,0.156 7.674,0.000 6.872,0.000 C6.070,0.000 5.304,0.156 4.572,0.467 C3.840,0.779 3.210,1.199 2.680,1.729 C2.150,2.260 1.730,2.890 1.419,3.621 C1.107,4.353 0.952,5.119 0.952,5.921 C0.952,6.723 1.107,7.490 1.419,8.222 C1.730,8.953 2.150,9.584 2.680,10.114 C3.210,10.644 3.840,11.064 4.572,11.375 C5.304,11.687 6.070,11.842 6.872,11.842 C8.105,11.842 9.224,11.495 10.227,10.800 L13.112,13.675 C13.313,13.888 13.566,13.995 13.868,13.995 C14.160,13.995 14.412,13.888 14.625,13.675 C14.838,13.462 14.945,13.210 14.945,12.918 C14.945,12.622 14.841,12.369 14.634,12.162 ZM9.534,8.583 C8.796,9.320 7.909,9.688 6.872,9.688 C5.835,9.688 4.948,9.320 4.210,8.583 C3.473,7.845 3.105,6.959 3.105,5.921 C3.105,4.884 3.473,3.997 4.210,3.260 C4.948,2.522 5.835,2.153 6.872,2.153 C7.909,2.153 8.796,2.522 9.534,3.260 C10.271,3.997 10.640,4.884 10.640,5.921 C10.640,6.959 10.271,7.845 9.534,8.583 Z"/>
                                </svg>
                                <span>{{trans('main.Search')}}</span>
                            </div>
                        </div>
                    </search-tours-form>
                    <search-excursions-form
                            inline-template
                            v-else
                            :action-url="'{{route('excursions.index')}}'"
                    >
                        <div class="search-block__forms-item"
                             key="excursions"
                             style="display: none"
                             ref="component"
                        >
                            <div class="search-block__forms-item-select">
                                <div class="search-block__forms-item-content"
                                     @click="openSelect = !openSelect"
                                >
                                    <span v-text="selectPlaceText ? selectPlaceText : '{{trans('searchForm.place from')}}'"></span>
                                    <svg class="angle" width="10" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 320 512">
                                        <path fill="currentColor"
                                              d="M151.5 347.8L3.5 201c-4.7-4.7-4.7-12.3 0-17l19.8-19.8c4.7-4.7 12.3-4.7 17 0L160 282.7l119.7-118.5c4.7-4.7 12.3-4.7 17 0l19.8 19.8c4.7 4.7 4.7 12.3 0 17l-148 146.8c-4.7 4.7-12.3 4.7-17 0z"></path>
                                    </svg>
                                </div>
                                <transition name="fade">
                                    <div v-show="openSelect"
                                         style="display: none"
                                         class="search-block__drop-down"
                                         v-click-outside="closeSelect"
                                    >
                                        <ul>
                                            <li>
                                                <a @click.prevent="selectPlace($event, 0)"
                                                   href=""
                                                >{{trans('searchForm.All cities')}}</a>
                                            </li>
                                            @foreach($excursion_filter_places as $place)
                                                <li>
                                                    <a @click.prevent="selectPlace($event, {{$place['id']}})"
                                                       href=""
                                                    >{{$place['name']}}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </transition>
                            </div>
                            <div class="search-block__forms-item-date">
                                <div class="search-block__forms-item-content">
                                    <i class="icon-calendar calendar"></i>
                                    <v-date-picker
                                            is-double-paned
                                            :show-day-popover="false"
                                            mode='single'
                                            :min-date='new Date()'
                                            v-model='selectedDate'
                                            :input-props='{placeholder: "{{trans('main.Date interval excursion')}}",readonly:true,style:"color:#000 !important"}'
                                    >
                                    </v-date-picker>
                                </div>
                            </div>
                            <div class="search-block__forms-item-submit" @click="submit">
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="15px" height="14px">
                                    <path fill-rule="evenodd" fill="rgb(0, 0, 0)"
                                          d="M14.634,12.162 L11.749,9.277 C12.445,8.273 12.792,7.155 12.792,5.921 C12.792,5.119 12.637,4.353 12.325,3.621 C12.015,2.890 11.594,2.260 11.064,1.729 C10.534,1.199 9.904,0.779 9.172,0.467 C8.440,0.156 7.674,0.000 6.872,0.000 C6.070,0.000 5.304,0.156 4.572,0.467 C3.840,0.779 3.210,1.199 2.680,1.729 C2.150,2.260 1.730,2.890 1.419,3.621 C1.107,4.353 0.952,5.119 0.952,5.921 C0.952,6.723 1.107,7.490 1.419,8.222 C1.730,8.953 2.150,9.584 2.680,10.114 C3.210,10.644 3.840,11.064 4.572,11.375 C5.304,11.687 6.070,11.842 6.872,11.842 C8.105,11.842 9.224,11.495 10.227,10.800 L13.112,13.675 C13.313,13.888 13.566,13.995 13.868,13.995 C14.160,13.995 14.412,13.888 14.625,13.675 C14.838,13.462 14.945,13.210 14.945,12.918 C14.945,12.622 14.841,12.369 14.634,12.162 ZM9.534,8.583 C8.796,9.320 7.909,9.688 6.872,9.688 C5.835,9.688 4.948,9.320 4.210,8.583 C3.473,7.845 3.105,6.959 3.105,5.921 C3.105,4.884 3.473,3.997 4.210,3.260 C4.948,2.522 5.835,2.153 6.872,2.153 C7.909,2.153 8.796,2.522 9.534,3.260 C10.271,3.997 10.640,4.884 10.640,5.921 C10.640,6.959 10.271,7.845 9.534,8.583 Z"/>
                                </svg>
                                <span>{{trans('main.Search')}}</span>
                            </div>
                        </div>
                    </search-excursions-form>
                </transition>
            </div>
        </div>
    </header>
</search-form>
