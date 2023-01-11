<template>
  <div class="event-block">
    <div class="event-block__image">
      <picture>
        <source :data-srcset="excursion.new_thumb.webp" type="image/webp"/>
        <source :data-srcset="excursion.new_thumb.jpg" type="image/jpeg"/>
        <img
            :alt="excursion.new_thumb.alt"
            :data-src="excursion.new_thumb.jpg"
            class="gallery-thumbs-swiper__img lazyload"
            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
        />
      </picture>
      <a :href="routeView.replace(':slug', excursion.slug)" class="p-aside-block__hover" target="_blank">
        <div class="p-aside-block__zoom">
          <svg fill="#ffffff" height="15px" viewBox="0 0 31 32" width="14px">
            <path
                d="M30.438 29.147l-7.622-7.924a12.848 12.848 0 0 0 3.022-8.304C25.838 5.784 20.054 0 12.919 0S0 5.784 0 12.919c0 7.135 5.784 12.919 12.919 12.919h.043c2.761 0 5.318-.876 7.407-2.366l-.039.026 7.678 7.98c.306.321.737.52 1.215.52.453 0 .865-.18 1.167-.472.319-.307.517-.738.517-1.215 0-.453-.178-.864-.469-1.167l.001.001zM12.925 3.358c5.277 0 9.554 4.277 9.554 9.554s-4.277 9.554-9.554 9.554a9.553 9.553 0 0 1-9.554-9.554c.008-5.273 4.281-9.546 9.553-9.554h.001z"
            ></path>
          </svg>
        </div>
      </a>
    </div>
    <div class="event-block__content">
      <div class="event-block__title">
        <a :href="routeView.replace(':slug', excursion.slug)" class="event-block__title-link" target="_blank">
          {{ excursion.title }}
        </a>
      </div>
      <div class="event-block__details-top mobile-reviews">
        <div class="event-block__rating">
          <show-star-rating :avgRating="+excursion.average_rating"></show-star-rating>
        </div>
        <div class="event-block__reviews">
          <div class="event-block__reviews-count">
            {{ excursion.reviews_count + excursion.generated_reviews_count }}
            <svg fill="none" height="13" style="vertical-align: -1px;" viewBox="0 0 13 13" width="13"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                  clip-rule="evenodd"
                  d="M6.49673 0C8.23387 0 9.86381 0.67611 11.0924 1.90465C12.3211 3.13319 13 4.763 13 6.5C13 8.237 12.3238 9.86681 11.0952 11.0953C9.84182 12.3486 8.17615 13 6.49398 13C5.44675 13 4.39128 12.7471 3.42651 12.2277C2.56069 12.8516 1.71411 12.9863 1.13965 12.9863C0.925252 12.9863 0.749339 12.967 0.625651 12.9478C0.361782 12.9066 0.158383 12.7004 0.117154 12.4366C0.0759242 12.1727 0.210607 11.9171 0.449738 11.7989C0.947241 11.5543 1.28257 11.0651 1.49147 10.6446C-0.638721 8.08034 -0.473803 4.27928 1.90102 1.90465C3.12966 0.67611 4.7596 0 6.49673 0ZM3.58043 11.4664C5.83981 12.7939 8.71213 12.4256 10.5675 10.5704C12.8131 8.32495 12.8131 4.67505 10.5647 2.4296C8.32183 0.184144 4.66889 0.184144 2.42326 2.4296C0.273826 4.57886 0.169378 8.04186 2.18138 10.3148C2.2336 10.3753 2.26384 10.4495 2.27208 10.5237C2.29132 10.6006 2.28583 10.6831 2.25284 10.7628C2.04669 11.2328 1.69487 11.8374 1.1369 12.2442H1.13965C1.6234 12.2442 2.35454 12.1233 3.09942 11.5461C3.10767 11.5378 3.11866 11.5296 3.12966 11.5241C3.24785 11.4059 3.43201 11.3784 3.58043 11.4664Z"
                  fill="black"
                  fill-rule="evenodd"
              />
              <path
                  d="M6.5 7C6.77614 7 7 6.77614 7 6.5C7 6.22386 6.77614 6 6.5 6C6.22386 6 6 6.22386 6 6.5C6 6.77614 6.22386 7 6.5 7Z"
                  fill="black"
              />
              <path
                  d="M8.5 7C8.77614 7 9 6.77614 9 6.5C9 6.22386 8.77614 6 8.5 6C8.22386 6 8 6.22386 8 6.5C8 6.77614 8.22386 7 8.5 7Z"
                  fill="black"
              />
              <path
                  d="M4.5 7C4.77614 7 5 6.77614 5 6.5C5 6.22386 4.77614 6 4.5 6C4.22386 6 4 6.22386 4 6.5C4 6.77614 4.22386 7 4.5 7Z"
                  fill="black"
              />
            </svg>
          </div>
        </div>
      </div>
      <div class="event-block__options">
        <div class="event-block__departure">
          <div class="event-block__departure-name">
            <template v-if="excursion.place">
              {{ excursion.place_name }}
            </template>
          </div>
          <div class="event-block__options-description">
            {{ 'listItem.Departure from' | trans }}
          </div>
        </div>
        <div class="event-block__duration">
          <div class="event-block__duration-name">
            {{ duration(excursion.duration) }}
          </div>
          <div class="event-block__options-description">
            {{ 'listItem.Duration' | trans }}
          </div>
        </div>
      </div>
      <div class="event-block__short-description" v-if="excursion.intro">{{ excursion.intro.slice(0, 80) }} ...</div>
    </div>
    <div class="event-block__details">
      <div class="event-block__details-top">
        <div class="event-block__rating">
          <show-star-rating :avgRating="+excursion.average_rating"></show-star-rating>
        </div>
        <div class="event-block__reviews">
          <div class="event-block__reviews-count">
            {{ 'listItem.Reviews' | choice(excursion.reviews_count + excursion.generated_reviews_count) }}
          </div>
        </div>
      </div>
      <div class="event-block__details-bottom">
        <div class="event-block__price">
          <template v-if="excursion.ribbon">
            <div class="event-block__price-old">
              <span class="event-block__price-from">{{ 'listItem.price from' | trans }}</span>
              {{ excursion.price | moneyFormatter }}
              <span class="event-block__price-from">{{ currencyCode }}</span>
            </div>
            <div class="event-block__price-new">
              <span class="event-block__price-from">{{ 'listItem.price from' | trans }}</span>
              {{ (excursion.price - Math.ceil((excursion.price * excursion.ribbon.discount) / 100)) | moneyFormatter }}
              <span class="event-block__price-from">{{ currencyCode }}</span>
            </div>
          </template>
          <div class="event-block__price-value" v-else>
            <span class="event-block__price-from">{{ 'listItem.price from' | trans }}</span>
            {{ excursion.price | moneyFormatter }}
            <span class="event-block__price-from">{{ currencyCode }}</span>
          </div>
          <div class="event-block__price-description">
            <span v-if="excursion.type === 'group'">
              {{ 'listItem.Per excursion' | trans }}
            </span>
            <span v-else>
              {{ 'listItem.Per person' | trans }}
            </span>
          </div>
        </div>
        <a :href="routeView.replace(':slug', excursion.slug)" class="event-block__more-button" target="_blank">
          <span class="event-block__more-button-icon"
          ><svg height="13" viewBox="0 0 17 13" width="17" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink">
              <image
                  height="13"
                  width="17"
                  xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAANCAYAAABPeYUaAAAAyUlEQVQoka2SMWpCURBFT2LKeY3NhSFYuYRAyjQ2ad2AYOsKsgI/dhYSsEjlMuIObAQhK1CwfrwEBEU+KOLH4r/gLWeYc+8w06Cm5BpYsJcU06I68VgXAkRgIle/2qidJMW0tGB/wNiCrVJMPxkBriVXIddOrk52krMs2Bx4BgoL9p1iWj/I1QRamazS/BNoA29PwAx4z97rouFdkmTbylUaT+X6les1G3CCjKrXyQV8yLWXq/tfQE+uw62PzXl7AwbbzfbrqgocARFfLLQwyj92AAAAAElFTkSuQmCC"
              ></image></svg
          ></span>
          <span class="event-block__more-button-text">{{ 'listItem.Learn more' | trans }}</span>
        </a>
      </div>
    </div>
  </div>
</template>
<script>
import ShowStarRating from './ShowStarRating';

export default {
  components: {ShowStarRating},
  props: ['excursion', 'routeView', 'currencyCode', 'currentPlace'],
  filters: {
    viewUrl(slug, routeView) {
      return routeView.replace(':slug', slug);
    },
  },
  methods: {
    duration(duration) {
      if (duration < 24) {
        return this.$options.filters.choice('listItem.hours', duration);
      } else if (duration % 24 === 0) {
        return this.$options.filters.choice('listItem.days', parseInt(duration / 24));
      } else {
        return (
            this.$options.filters.choice('listItem.days', parseInt(duration / 24)) +
            ' ' +
            this.$options.filters.choice('listItem.hours', parseInt(duration % 24))
        );
      }
    },
  },
};
</script>
