<div class="aside__block">
        <div class="event-block">
            <div class="event-block__image">
                <picture>
                  <source type="image/webp"
                          data-srcset="{{$imageSrc['webp']}}"
                  >
                  <source type="image/jpeg"
                          data-srcset="{{$imageSrc['jpg']}}"
                  >
                  <img class="gallery-thumbs-swiper__img lazyload"
                       src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                       data-src="{{$imageSrc['jpg']}}"
                       alt="{{$imageSrc['alt']}}"
                  >
                </picture>
{{--                <img src="{{$imageSrc}}" alt="">--}}
{{--                <div class="event-block__image-title">{{$type}}</div>--}}
                <a href="{{$href}}" class="event-block__image-hover">
                    <div class="event-block__image-hover-zoom">
                        <svg width="14px" height="15px" fill="#ffffff" viewBox="0 0 31 32">
                            <path d="M30.438 29.147l-7.622-7.924a12.848 12.848 0 0 0 3.022-8.304C25.838 5.784 20.054 0 12.919 0S0 5.784 0 12.919c0 7.135 5.784 12.919 12.919 12.919h.043c2.761 0 5.318-.876 7.407-2.366l-.039.026 7.678 7.98c.306.321.737.52 1.215.52.453 0 .865-.18 1.167-.472.319-.307.517-.738.517-1.215 0-.453-.178-.864-.469-1.167l.001.001zM12.925 3.358c5.277 0 9.554 4.277 9.554 9.554s-4.277 9.554-9.554 9.554a9.553 9.553 0 0 1-9.554-9.554c.008-5.273 4.281-9.546 9.553-9.554h.001z">
                            </path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
        <div class="event-block__content">
            <a href="{{$href}}" class="event-block__title">{{$title}}</a>
            <div class="event-block__params">
                <div class="event-block__params-time">
                    <svg class="event-block__params_icon" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 47.001 47.001" style="enable-background:new 0 0 47.001 47.001;"
                     xml:space="preserve">
                    <g>
                      <g id="Layer_1_65_">
                        <g>
                          <path d="M46.907,20.12c-0.163-0.347-0.511-0.569-0.896-0.569h-2.927C41.223,9.452,32.355,1.775,21.726,1.775
                            C9.747,1.775,0,11.522,0,23.501C0,35.48,9.746,45.226,21.726,45.226c7.731,0,14.941-4.161,18.816-10.857
                            c0.546-0.945,0.224-2.152-0.722-2.699c-0.944-0.547-2.152-0.225-2.697,0.72c-3.172,5.481-9.072,8.887-15.397,8.887
                            c-9.801,0-17.776-7.974-17.776-17.774c0-9.802,7.975-17.776,17.776-17.776c8.442,0,15.515,5.921,17.317,13.825h-2.904
                            c-0.385,0-0.732,0.222-0.896,0.569c-0.163,0.347-0.11,0.756,0.136,1.051l4.938,5.925c0.188,0.225,0.465,0.355,0.759,0.355
                            c0.293,0,0.571-0.131,0.758-0.355l4.938-5.925C47.018,20.876,47.07,20.467,46.907,20.12z"/>
                          <path d="M21.726,6.713c-1.091,0-1.975,0.884-1.975,1.975v11.984c-0.893,0.626-1.481,1.658-1.481,2.83
                            c0,1.906,1.551,3.457,3.457,3.457c0.522,0,1.014-0.125,1.458-0.334l6.87,3.965c0.312,0.181,0.65,0.266,0.986,0.266
                            c0.682,0,1.346-0.354,1.712-0.988c0.545-0.943,0.222-2.152-0.724-2.697l-6.877-3.971c-0.092-1.044-0.635-1.956-1.449-2.526V8.688
                            C23.701,7.598,22.816,6.713,21.726,6.713z M21.726,24.982c-0.817,0-1.481-0.665-1.481-1.48c0-0.816,0.665-1.481,1.481-1.481
                            s1.481,0.665,1.481,1.481C23.207,24.317,22.542,24.982,21.726,24.982z"/>
                        </g>
                      </g>
                    </g>
                    </svg>
                    <span class="event-block__params_text">{{$time}}</span>
                </div>
                <div class="event-block__params-separate"></div>
                <div class="event-block__params-place">
                    <svg class="event-block__params_icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                    <g>
                     <path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035
                       c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719
                       c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z"/>
                    </g>
                    </svg>
                    <span class="event-block__params_text">{{$place}}</span>
                </div>
            </div>
        </div>
{{--        <div class="event-block__route">--}}
{{--            <strong>Маршрут:</strong> Анкалия - Телави - Тбилиси - Анкалия - Батуми - Телави--}}
{{--        </div>--}}
        <div class="event-block__footer">
            <div class="event-block__footer-price">
                @if($newPrice)
                <span class="old-price">{{trans('base_aside.from')}} <span class="big-letter">{{$price}}</span>{{currency()->getUserCurrency()}}</span>
                <span class="new-price">{{trans('base_aside.from')}} <span class="big-letter">{{$newPrice}}</span>{{currency()->getUserCurrency()}}</span>
                @else
                <span>{{trans('base_aside.from')}} <span class="big-letter">{{$price}}</span>&nbsp;{{currency()->getUserCurrency()}}</span>
                @endif
            </div>
            <a href="{{$href}}"
               target="_blank" class="event-block__more-button"><span class="event-block__more-button-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="13" viewBox="0 0 17 13"><image width="17" height="13" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAANCAYAAABPeYUaAAAAyUlEQVQoka2SMWpCURBFT2LKeY3NhSFYuYRAyjQ2ad2AYOsKsgI/dhYSsEjlMuIObAQhK1CwfrwEBEU+KOLH4r/gLWeYc+8w06Cm5BpYsJcU06I68VgXAkRgIle/2qidJMW0tGB/wNiCrVJMPxkBriVXIddOrk52krMs2Bx4BgoL9p1iWj/I1QRamazS/BNoA29PwAx4z97rouFdkmTbylUaT+X6les1G3CCjKrXyQV8yLWXq/tfQE+uw62PzXl7AwbbzfbrqgocARFfLLQwyj92AAAAAElFTkSuQmCC"></image></svg></span>
                <span class="event-block__more-button-text">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="17" height="13" viewBox="0 0 17 13"><image width="17" height="13" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAANCAYAAABPeYUaAAAAyUlEQVQoka2SMWpCURBFT2LKeY3NhSFYuYRAyjQ2ad2AYOsKsgI/dhYSsEjlMuIObAQhK1CwfrwEBEU+KOLH4r/gLWeYc+8w06Cm5BpYsJcU06I68VgXAkRgIle/2qidJMW0tGB/wNiCrVJMPxkBriVXIddOrk52krMs2Bx4BgoL9p1iWj/I1QRamazS/BNoA29PwAx4z97rouFdkmTbylUaT+X6les1G3CCjKrXyQV8yLWXq/tfQE+uw62PzXl7AwbbzfbrqgocARFfLLQwyj92AAAAAElFTkSuQmCC"></image></svg>
                </span></a>
        </div>
    </div>
