<template>
  <div class="search-block">
    <div class="search-block__departure">
      <div class="search-block__label">{{ 'search.from place' | trans }}:</div>
      <div class="search-block__input-wrap">
        <div class="search-block__input_city-wrap" :class="{ 'search-block__input_city_selected': activeCity }">
          <input
            class="search-block__input search-block__input_city"
            type="text"
            name=""
            :value="selectPlaceText"
            readonly=""
            @click.stop="openSelect = true"
          />
          <span class="city-tick">
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="13" viewBox="0 0 15 13">
              <image
                id="check-mark"
                width="15"
                height="13"
                xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAANCAYAAAB2HjRBAAAAwElEQVQokZ3SPQ4BURDA8f+KRoGGyhm8xBQOsIUzOIozOIYzSIhCLYoJL3qNzkeil6zMZlcE+2W6Ny+/mTcvE0RRRJUQL3WgpU5vlbB46QMLoAdMS+MEroFOknrU/oQWm2CwHwSAA07q9FoSHoDQOs+AHXAUL2FZqE7PhsdJsgnM0wJF0A6Gl2+XjaTApAha2MxtYAUMc/7sC8ad1ekdGAHbKjB9NjkFMuELfxSwWeNUHoxn/rVh4qULXNRp9voBT1j+XQVv1YdeAAAAAElFTkSuQmCC"
              />
            </svg>
          </span>
        </div>
        <transition name="fade">
          <div class="count-results" v-show="showCountResults">
            {{ 'search.Found' | trans }}: <strong>{{ total }}</strong>
          </div>
        </transition>
        <transition name="fade">
          <div v-show="openSelect" class="drop-down-day" v-click-outside="closeSelect">
            <ul class="drop-down-day__list">
              <li>
                <a class="drop-down-day__item" @click.prevent="selectPlace($event, 0)" href="">{{ 'search.All cities' | trans }}</a>
              </li>
              <li v-for="place in places" :key="place.id">
                <a class="drop-down-day__item" @click.prevent="selectPlace($event, place.id)" href="">{{ place.name }}</a>
              </li>
            </ul>
          </div>
        </transition>
      </div>
    </div>
    <div class="search-block__date">
      <div class="search-block__label">{{ 'search.Tour date' | trans }}:</div>
      <div class="search-block__input-wrap">
        <div class="date-block-wrap search-block__input_date">
          <span class="date-icon"
            ><i class="icon-calendar"></i></span>
          <span v-if="date" class="date-reset" title="Сбросить дату" @click="date=null;emitChanges()">
            <svg width="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z" class=""></path></svg>
          </span>
          <v-date-picker
            is-double-paned
            :show-day-popover="false"
            :popover="{ placement: 'right-start' }"
            mode="range"
            :min-date="new Date()"
            v-model="date"
            @input="emitChanges()"
            :input-props="{
              placeholder: $options.filters.trans('search.Tour date'),
              readonly: true,
              class: 'search-block__input',
              id: 'search-block__date'
            }"
          >
          </v-date-picker>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import clickOutside from '../../../directives/clickOutside';
import dateFormat from 'dateformat';
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';
import Vue from 'vue';
Vue.use(VCalendar, {
  firstDayOfWeek: 2,
  locale: window.Laravel.locale,
});

export default {
  props: ['places', 'params', 'total'],
  directives: { clickOutside },
  data() {
    return {
      placeId: null,
      selectPlaceText: this.$options.filters.trans('search.All cities'),
      date: null,
      openSelect: false,
      activeCity: false,
      showCountResults: false,
    };
  },
  methods: {
    selectPlace(event, placeId) {
      this.activeCity = !!placeId;
      this.openSelect = false;
      this.placeId = placeId;
      this.selectPlaceText = event.target.innerText;
      this.emitChanges();
    },
    closeSelect(event) {
      if (event.target.className !== 'search-block__input') {
        this.openSelect = false;
      }
    },
    emitChanges() {
      let changes = {};
      if (this.placeId) {
        changes.place = this.placeId;
      }
      if (this.date) {
        changes.date = [dateFormat(this.date.start, 'isoDate'), dateFormat(this.date.end, 'isoDate')];
      }
      this.$emit('change', { ...changes });
    },
    submit() {
      this.$emit('submit');
    },
  },
  watch: {
    total() {
      let t = this;
      t.showCountResults = true;
      setTimeout(function() {
        t.showCountResults = false;
      }, 1500);
    },
  },
  created() {
    if (this.params.place) {
      this.placeId = parseInt(this.params.place);
      this.selectPlaceText = this.places.find(({ id }) => id === this.placeId).name;
    }
    if (this.params.date) {
      this.date = {
        start: new Date(this.params.date[0]),
        end: new Date(this.params.date[1]),
      };
    }
    this.activeCity = !!this.placeId;
  },
};
</script>
