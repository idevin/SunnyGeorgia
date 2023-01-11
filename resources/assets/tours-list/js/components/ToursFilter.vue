<template>
  <div class="aside">
    <div class="aside-title">{{ 'filter.Filter' | trans }}</div>
    <div class="aside-content">
      <div class="filter-block">
        <div class="filter-block__reset" @click="reset()" v-if="filterResetStatus">
          <span class="filter-block__reset-symbol">
            <svg width="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M193.94 256L296.5 153.44l21.15-21.15c3.12-3.12 3.12-8.19 0-11.31l-22.63-22.63c-3.12-3.12-8.19-3.12-11.31 0L160 222.06 36.29 98.34c-3.12-3.12-8.19-3.12-11.31 0L2.34 120.97c-3.12 3.12-3.12 8.19 0 11.31L126.06 256 2.34 379.71c-3.12 3.12-3.12 8.19 0 11.31l22.63 22.63c3.12 3.12 8.19 3.12 11.31 0L160 289.94 262.56 392.5l21.15 21.15c3.12 3.12 8.19 3.12 11.31 0l22.63-22.63c3.12-3.12 3.12-8.19 0-11.31L193.94 256z" class=""></path></svg>
          </span>
          {{ 'filter.Reset filters' | trans }}
        </div>
        <div class="filter-section">
          <div class="filter-section__title">
            <span class="filter-section__title-show-hide"></span>
            {{ 'filter.Duration of tour' | trans }}
          </div>
          <div class="filter-section__items">
            <template v-for="(duration, index) in allDurations">
              <div class="filter-section-item" :key="duration.name">
                <label class="checkbox-row" :class="{ disabled: !durationMatch(duration) }">
                  <div class="checkbox checkbox-primary">
                    <input
                      type="checkbox"
                      :value="index"
                      class="checkbox-field"
                      v-model="selectedDurations"
                      :disabled="!durationMatch(duration)"
                      @change="emitChanges()"
                    />
                    <span class="checkbox-label"></span>
                  </div>
                  <span class="filter-text">{{ duration.name }}</span>
                </label>
              </div>
            </template>
          </div>
        </div>
        <div class="filter-section">
          <div class="filter-section__title">
            <span class="filter-section__title-show-hide"></span>
            {{ 'filter.Price' | trans }} ({{ currencyCode }})
          </div>
          <div class="filter-section__items filter-section__items_price">
            <div class="filter-section-item">
              <vue-slider
                ref="slider"
                v-model="selectedPrice"
                @drag-end="emitChanges()"
                tooltip="always"
                :enableCross="true"
                :contained="true"
                :min="serverData.priceMin"
                :max="serverData.priceMax"
                :lazy="true"
                :tooltip-placement="['bottom', 'top']"
                :dotOptions="{
                  focusStyle: { 'box-shadow': '0.5px 0.5px 2px 1px rgb(237, 188, 40, 0.5)' },
                }"
                :processStyle="{ 'background-color': '#edbc28' }"
                :tooltipStyle="{
                  'background-color': '#edbc28',
                  'border-color': '#edbc28',
                  cursor: 'pointer',
                  'font-size': '12px',
                }"
              ></vue-slider>
            </div>
          </div>
        </div>
        <div class="filter-section">
          <div class="filter-section__title filter-section__title_hide">
            <span class="filter-section__title-show-hide"></span>
            {{ 'filter.Type of tour' | trans }}
          </div>
          <div class="filter-section__items">
            <div class="filter-section-item" v-for="type in serverData.types" :key="type.id">
              <label class="checkbox-row">
                <div class="checkbox checkbox-primary">
                  <input type="checkbox" :value="type.id" class="checkbox-field" v-model="selectedTypes" @change="emitChanges()" />
                  <span class="checkbox-label"></span>
                </div>
                <span class="filter-text">{{ type.name }}</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { stringify } from 'qs';
import ApiFilter from '../../../api/Filter';
import VueSlider from 'vue-slider-component';
import 'vue-slider-component/theme/default.css';

export default {
  props: ['currencyCode', 'params'],
  components: { VueSlider },
  data() {
    return {
      serverData: {
        priceMin: null,
        priceMax: 1000000000,
        types: [],
        durationMin: null,
        durationMax: null,
      },
      allDurations: [
        { name: this.$options.filters.trans('filter.1-4 days'), min: 1, max: 4 },
        { name: this.$options.filters.trans('filter.5-9 days'), min: 5, max: 9 },
        { name: this.$options.filters.trans('filter.10 and more days'), min: 10, max: 1000 },
      ],
      selectedDurations: [],
      selectedTypes: [],
      selectedPrice: [],
    };
  },
  created() {
    this.getToursParams();
  },
  computed: {
    filterResetStatus() {
      return !(this.selectedPrice[0] === this.serverData.priceMin &&
              this.selectedPrice[1] === this.serverData.priceMax &&
              !this.selectedKind &&
              this.selectedDurations.length === 0 &&
              this.selectedTypes.length === 0);
    }
  },
  methods: {
    durationMatch(duration) {
      if (!this.serverData.durationMin && !this.serverData.durationMax) {
        return false;
      }
      return (
        (duration.min >= this.serverData.durationMin && duration.min <= this.serverData.durationMax) ||
        (duration.max >= this.serverData.durationMin && duration.max <= this.serverData.durationMax)
      );
    },
    getToursParams() {
      const query = {};
      if (this.params.date) {
        query.date = this.params.date;
      }
      if (this.params.place) {
        query.place = this.params.place;
      }
      ApiFilter.getToursParams(stringify({ filter: { ...query } }))
        .then(({ data }) => {
          if (data.count) {
            this.serverData = data;
            if(this.$refs.slider) {
              this.$refs.slider.setValue([data.priceMin, data.priceMax]);
            }
          } else {
            console.log('no results');
          }
          this.mapPropsToData();
        })
        .catch(error => {
          console.error(error);
        });
    },
    emitChanges() {
      let changes = {};
      if (this.selectedDurations.length) {
        // case when shortest and longest durations selected
        if (this.selectedDurations.length === 2 && this.selectedDurations.includes(0) && this.selectedDurations.includes(2)) {
          changes.duration = [[this.allDurations[0].min, this.allDurations[0].max], [this.allDurations[2].min, this.allDurations[2].max]];
        } else {
          const initial = [this.allDurations[this.selectedDurations[0]].min, this.allDurations[this.selectedDurations[0]].max];
          changes.duration = this.selectedDurations.reduce((carry, item) => {
            if (this.allDurations[item].min < carry[0]) {
              carry[0] = this.allDurations[item].min;
            }
            if (this.allDurations[item].max > carry[1]) {
              carry[1] = this.allDurations[item].max;
            }
            return carry;
          }, initial);
        }
      }
      if (this.selectedTypes.length) {
        changes.types = this.selectedTypes;
      }
      if (this.selectedPrice.length) {
        changes.price = {};
        if (this.selectedPrice[0] > this.serverData.priceMin) {
          changes.price.from = this.selectedPrice[0];
        }
        if (this.selectedPrice[1] < this.serverData.priceMax) {
          changes.price.to = this.selectedPrice[1];
        }
      }
      this.$emit('change', { ...changes });
    },
    reset() {
      this.selectedDurations = [];
      this.selectedTypes = [];
      this.selectedPrice = [this.serverData.priceMin, this.serverData.priceMax];
      this.emitChanges();
    },
    mapPropsToData() {
      if (this.params) {
        if (this.params.types) {
          this.selectedTypes = this.params.types.map(type => +type);
        }
        if (this.params.price) {
          this.selectedPrice = [this.params.price.from || this.serverData.priceMin, this.params.price.to || this.serverData.priceMax];
        }
        if (this.params.duration) {
          this.selectedDurations = [];
          if (Array.isArray(this.params.duration[0])) {
            this.allDurations.forEach(({ min, max }, index) => {
              if (
                (+this.params.duration[0][0] === min && +this.params.duration[0][1] === max) ||
                (+this.params.duration[1][0] === min && +this.params.duration[1][1] === max)
              ) {
                this.selectedDurations.push(index);
              }
            });
          } else {
            this.allDurations.forEach(({ min, max }, index) => {
              if (min >= +this.params.duration[0] && max <= +this.params.duration[1]) {
                this.selectedDurations.push(index);
              }
            });
          }
        }
      }
    },
  },
};
</script>
<style scoped>
.disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
