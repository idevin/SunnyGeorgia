<template>
    <div class="filter-container">
        <div class="filter-container__loading" v-if="loading">
            <shared-loader></shared-loader>
        </div>
        <div class="filter-container__content" v-if="!loading">

            <button type="button" class="filter-clear" @click.prevent="onFilterReset">
                <span aria-hidden="true" class="filter-clear-icon">×</span>
                <span>{{$t('filter.Reset_filters')}}</span>

            </button>

            <div class="filter-group vue-slider-wrapper--default">
                <label class="filter-label">{{$t('filter.Price')}} ({{ currencyCode.code }})</label>
                <vue-slider v-bind="price.options" v-model="price.options.value" @drag-end="filterChange()"></vue-slider>
            </div>

            <div class="filter-group">
                <div role="tablist" class="filter-collapse" v-for="item in excursionFilterOptions" v-if="item.id != 26">
                    <div class="filter-collapse-item">
                        <div role="tab" id="toursHead">
                            <h5>
                                <a data-toggle="collapse" :href="'#'+ item.id" role="button" aria-expanded="true"
                                   aria-controls="collapse-tours">
                                    {{ item.title }}
                                </a>
                            </h5>
                        </div>
                        <div :id="item.id" class="collapse show" role="tabpanel" aria-labelledby="toursHead">
                            <ul class="list-unstyled filter-checkboxes">
                                <li v-for="option in item.options" class="super-button-wrapper">
                                    <label :for="option.id" class="checkbox-row">
                                        <div class="checkbox checkbox-primary">
                                            <input :id="option.id" type="checkbox" class="checkbox-field" :value="option.id" :name="option.id" @change="filterChange()" v-model="getData.options">
                                            <span class="checkbox-label"></span>
                                        </div>
                                        <span class="filter-text">{{ option.title }}</span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import vueSlider    from 'vue-slider-component';
// import { EventBus } from '../../app.js';

const qs = require('qs');

export default {
    props: ['trans', 'maxPrice'],
    computed: {
        loading() {
            return this.$store.getters.loading
        },
        currencyCode() {
            return this.$store.getters.currency
        }
    },
    data() {
        return {
            localization: [],
            excursionFilterOptions: null,
            getData: {
                days_ranges: [],
                options: [],
                price_ranges: {
                    from: null,
                    to: null,
                }
            },
            price: {
                options: {
                    value: [],
                    tooltipDir: ['bottom', 'top'],
                    min: 1,
                    max: null
                }
            }
        }
    },
    created() {
        this.$store.dispatch('receiveLoading', true)
        this.localization = JSON.parse(this.trans);
        this.price.options.max = parseInt(this.maxPrice);
        document.addEventListener("DOMContentLoaded", () => {
            this.excursionFilterOptions = window.filter_options
            this.getData = qs.parse(window.location.search.substring(1))
            this.receivePriceValue()
            this.receiveOptions()
            // this.filterChange()
            this.$store.dispatch('receiveLoading', false)
        })
    },
    components: {
        vueSlider
    },
    watch: {
        "price.options.value"() {
            this.getData.price_ranges.from = this.price.options.value[0]
            this.getData.price_ranges.to = this.price.options.value[1]
        }
    },
    methods: {
        locationHref(getString) {
            let url = location.href.split("?");
            window.history.pushState("", "", url[0] + getString);
        },
        filterChange() {
            let getString = qs.stringify(this.getData);
            this.locationHref("?" + getString);
            // EventBus.$emit("filterExcursionsChange", getString);
        },
        receiveOptions() {
            if (this.getData.options) {
                this.getData.options = this.getData.options
            } else {
                this.getData.options = []
            }
        },
        onFilterSubmit() {
            this.getData.price_ranges.from = this.price.options.value[0]
            this.getData.price_ranges.to = this.price.options.value[1]

            let modifiedGetData = qs.stringify(this.getData)

            let currentURL = location.protocol + '//' + location.host + location.pathname
            window.location.href = currentURL + "?" + modifiedGetData
        },
        onFilterReset() {
            this.getData.days_ranges = [];
            this.getData.options = [];

            this.price.options.value = [];
            this.price.options.value.push(this.price.options.min)
            this.price.options.value.push(this.price.options.max)


            this.getData.price_ranges = {
                from: this.price.options.min,
                to: this.price.options.max
            };


            let getString = qs.stringify(this.getData);
            this.locationHref("?" + getString);
            // EventBus.$emit("filterExcursionsChange", "");
        },
        receivePriceValue() {

            if (this.getData.price_ranges) {
                this.price.options.value.push(this.getData.price_ranges.from)
                this.price.options.value.push(this.getData.price_ranges.to)
            } else {
                this.getData.price_ranges = {
                    from: this.price.options.min,
                    to: this.price.options.max,
                }
                this.price.options.value.push(this.price.options.min)
                this.price.options.value.push(this.price.options.max)
            }
        },
        optionsChange(el) {
            $('.super_button').remove();
            let htmlButton = '<div class="super_button"><button type="button" id="submitButtonFloat" class="filter-button btn btn-secondary btn-block text-black font-weight-bold">' + $t('filter.Apply') + '</button></div>';
            $(el.target).parent().append(htmlButton);
            $('#submitButtonFloat').on('click', (event) => {
                this.onFilterSubmit()
            })
        }
    }
}
</script>
<style lang="scss">
.super-button-wrapper {
    position: relative;
}

.list-unstyled li {
    position: relative;
}

.filter-group {
    position: relative;
}

.align-center,
.filter-container__loading {
    text-align: center;
}

.vue-slider-component {
    margin: 30px 0 47px 0;
}

// Default Styles for Slider-Component--default
.vue-slider-wrapper--default .vue-slider-component .vue-slider-tooltip {
    display: block;
    font-size: 14px;
    white-space: nowrap;
    padding: 2px 5px;
    min-width: 20px;
    text-align: center;
    color: #fff;
    border-radius: 5px;
    border: 1px solid #ffc411;
    background-color: #ffc411;
}

.vue-slider-wrapper--default .vue-slider-component .vue-slider-process {
    position: absolute;
    border-radius: 15px;
    background-color: #edb715;
    transition: all 0s;
    z-index: 1;
}

.super_button {
    position: absolute;
    left: -135px;
    background: white;
    padding: 10px;
    border: 1px solid yellow;
    box-shadow: 1px 1px 8px rgba(0, 0, 0, .5);
    z-index: 1;
}

@media screen and (max-width: 992px) {
    #submitButtonFloat {
        display: none;
    }
}
</style>
