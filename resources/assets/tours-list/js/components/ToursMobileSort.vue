<template>
    <div class="mobile-sort-block d-md-none">
        <div class="mobile-sort-block__filter">
            <div @click="showFilter=!showFilter" class="mobile-sort-block__filter-label">Фильтр</div>
        </div>
        <div class="mobile-sort-block__sort">
            <select class="mobile-sort-block__sort-label"
                    v-model="sort"
                    @change="emitChanges2()"
            >
                <option value="price">{{'sort.Price: low' | trans}}</option>
                <option value="-price">{{'sort.Price: high' | trans}}</option>
                <option value="discount">{{'sort.Discounts' | trans}}</option>
                <option value="created_at">{{'sort.New' |trans}}</option>
                <option value="duration">{{'sort.Duration' |trans}}</option>
                <option value="-duration">{{'sort.-Duration' |trans}}</option>
            </select>
        </div>
        <div class="mobile-sort-block__result">
            Найдено: {{total}}
        </div>
        <transition name="fade">
            <div class="mobile-sort-block__filter-wrap" v-if="showFilter" v-click-outside="closeFilter">
                <div class="filter-block">
                    <div class="filter-block__reset" @click="reset()">
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
                                                    @change="emitChanges1()"
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
                                        @drag-end="emitChanges1()"
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
                                        <input type="checkbox" :value="type.id" class="checkbox-field" v-model="selectedTypes" @change="emitChanges1()" />
                                        <span class="checkbox-label"></span>
                                    </div>
                                    <span class="filter-text">{{ type.name }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="filter-close" @click="showFilter = false">
                    <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M168.5 164.2l148 146.8c4.7 4.7 4.7 12.3 0 17l-19.8 19.8c-4.7 4.7-12.3 4.7-17 0L160 229.3 40.3 347.8c-4.7 4.7-12.3 4.7-17 0L3.5 328c-4.7-4.7-4.7-12.3 0-17l148-146.8c4.7-4.7 12.3-4.7 17 0z" class=""></path></svg>
                </div>
            </div>
        </transition>
    </div>
</template>
<script>
    import {stringify} from 'qs';
    import clickOutside from '../../../directives/clickOutside';
    import ApiFilter from '../../../api/Filter';
    import VueSlider from 'vue-slider-component';
    import 'vue-slider-component/theme/default.css';

    export default {
        props: ['currencyCode', 'param1', 'param2', 'total'],
        components: { VueSlider },
        directives: { clickOutside },
        data() {
            return {
                sort: 'price',
                showFilter: false,
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
            if(this.param2) {
                this.sort = this.param2
            }
            let t = this
            setTimeout(function () {
                let search_date = document.getElementById('search-block__date');
                search_date.addEventListener('click', function () {
                    t.showFilter = false
                })
            }, 1000)
        },
        methods: {
            closeFilter(event){
                if (event.target.className !== 'mobile-sort-block__filter-label') {
                    this.showFilter = false;
                }
            },
            emitChanges2(){
                this.$emit('change2', this.sort)
            },
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
                if (this.param1.date) {
                    query.date = this.param1.date;
                }
                if (this.param1.place) {
                    query.place = this.param1.place;
                }
                ApiFilter.getToursParams(stringify({ filter: { ...query } }))
                    .then(({ data }) => {
                        if (data.count) {
                            this.serverData = data;
                            this.$refs.slider.setValue([data.priceMin, data.priceMax]);
                        } else {
                            console.log('no results');
                        }
                        this.mapPropsToData();
                    })
                    .catch(error => {
                        console.error(error);
                    });
            },
            emitChanges1() {
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
                this.$emit('change1', { ...changes });
            },
            reset() {
                this.selectedDurations = [];
                this.selectedTypes = [];
                this.selectedPrice = [this.serverData.priceMin, this.serverData.priceMax];
                this.emitChanges1();
            },
            mapPropsToData() {
                if (this.param1) {
                    if (this.param1.types) {
                        this.selectedTypes = this.param1.types.map(type => +type);
                    }
                    if (this.param1.price) {
                        this.selectedPrice = [this.param1.price.from || this.serverData.priceMin, this.param1.price.to || this.serverData.priceMax];
                    }
                    if (this.param1.duration) {
                        this.selectedDurations = [];
                        if (Array.isArray(this.param1.duration[0])) {
                            this.allDurations.forEach(({ min, max }, index) => {
                                if (
                                    (+this.param1.duration[0][0] === min && +this.param1.duration[0][1] === max) ||
                                    (+this.param1.duration[1][0] === min && +this.param1.duration[1][1] === max)
                                ) {
                                    this.selectedDurations.push(index);
                                }
                            });
                        } else {
                            this.allDurations.forEach(({ min, max }, index) => {
                                if (min >= +this.param1.duration[0] && max <= +this.param1.duration[1]) {
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
