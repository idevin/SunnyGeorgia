<template>
    <div class="shared-weather" v-if="weather.length > 0">
        <div class="shared-weather__item">
            <div class="local-weather">
                <div class="local-weather__main">
                    <div class="local-weather__main-item row">
                        <div class="col-8">
                            <div><small>{{ weatherFirst | dateFormatter}}</small></div>
                            <div><span>{{ weatherFirst.summary }}</span></div>
                        </div>
                        <div class="col-4 text-center">
                            <div v-if="false" class="icon-w sun-shower">
                                <div class="cloud"></div>
                                <div class="sun">
                                    <div class="rays"></div>
                                </div>
                                <div class="rain"></div>
                            </div>
                            <div v-if="weatherFirst.icon == 'thunderstorm' || weatherFirst.icon == 'tornado'" class="icon-w thunder-storm">
                                <div class="cloud"></div>
                                <div class="lightning">
                                    <div class="bolt"></div>
                                    <div class="bolt"></div>
                                </div>
                            </div>
                            <div v-if="weatherFirst.icon == 'partly-cloudy-day' || weatherFirst.icon == 'partly-cloudy-night' || weatherFirst.icon == 'wind' || weatherFirst.icon == 'fog' || weatherFirst.icon == 'cloudy'" class="icon-w cloudy">
                                <div class="cloud"></div>
                                <div class="cloud"></div>
                            </div>
                            <div v-if="weatherFirst.icon == 'snow' || weatherFirst.icon == 'sleet'" class="icon-w flurries">
                                <div class="cloud"></div>
                                <div class="snow">
                                    <div class="flake"></div>
                                    <div class="flake"></div>
                                </div>
                            </div>
                            <div v-if="weatherFirst.icon == 'rain'" class="icon-w rainy">
                                <div class="cloud"></div>
                                <div class="rain"></div>
                            </div>
                            <div v-if="weatherFirst.icon == 'clear-day' || weatherFirst.icon == 'clear-night'" class="icon-w sunny">
                                <div class="sun">
                                    <div class="rays"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="local-weather__header">
                        <div class="row">
                            <div class="local-weather__title col-7">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                {{ place.name }}
                            </div>
                            <div class="col-5 text-right">
                                <span class="local-weather__grad-num">
                                <small>{{ weatherFirst | temperatureSymbol }}</small> {{ weatherFirst | averageTemperature }}
                                <sup><small>℃</small></sup></span>
                            </div>
                        </div>
                    </div>
                    <div class="local-weather__main-item text-center">
                        <div class="weather-forecast">
                            <div class="weather-forecast__item" v-for="(item, index) in weather">
                                <div class="weather-forecast__date" style="color: #969696;">
                                    <small>{{ item | dateFormatter}}</small>
                                </div>
                                <div class="weather-forecast__content">
                                    <span><small>{{item | temperatureSymbol}}</small> {{item | averageTemperature}}</span>
<!--                                    <div>-->
<!--                                        <icon v-if="item.icon == 'clear-day' || item.icon == 'clear-night'" name="sun-o" style="color: #e8b912;" scale="1"></icon>-->
<!--                                        <icon v-if="item.icon == 'rain'" style="color: #3591A6;" name="tint" scale="1"></icon>-->
<!--                                        <icon v-if="item.icon == 'partly-cloudy-day' || item.icon == 'partly-cloudy-night' || item.icon == 'wind' || item.icon == 'fog' || item.icon == 'cloudy'" name="cloud" style="color: #43C2E3;" scale="1"></icon>-->
<!--                                        <icon v-if="item.icon == 'thunderstorm' || item.icon == 'tornado'" style="color: #c6f6ff;" name="bolt" scale="1"></icon>-->
<!--                                        <icon v-if="item.icon == 'snow' || item.icon == 'sleet'" style="color: #8acdd8;" name="snowflake-o" scale="1"></icon>-->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import * as moment from 'moment';
import 'moment/locale/ru';
import 'moment/locale/ka';

export default {
    props: ['placeData'],
    data() {
        return {
            amountDays: 4,
            place: this.placeData,
            weather: []
        }
    },
    mounted() {
        this.loadWeather();
    },
    filters: {
        temperatureSymbol: function(item) {
            var temp = parseInt((item.apparentTemperatureMax + item.apparentTemperatureMin) / 2);
            if (temp > 0) {
                return '+';
            } else if (temp < 0) {
                return '-';
            } else {
                return '';
            }
        },
        averageTemperature: function(item) {
            var temp = parseInt((item.apparentTemperatureMax + item.apparentTemperatureMin) / 2);
            return Math.abs(temp);
        },
        dateFormatter: function(item) {
            moment.locale(window.document.documentElement.lang)
            var date = moment.unix(item.time)
            return date.format("MMM D")
        }
    },
    computed: {
        weatherFirst: function() {
            return this.weather.shift();
        }
    },
    methods: {
        loadWeather() {
            var self = this
            if (self.place.lat && self.place.long) {
                axios.get('/xhr/weather?lat=' + self.place.lat + '&long=' + self.place.long + '&lang=' + window.document.documentElement.lang)
                    .then(function(response) {
                        self.weather = response.data.weather.slice(0, self.amountDays);
                    })
                    .catch(function(error) {
                        console.log(error)
                    });
            }
        }
    }
}
</script>
<style lang="scss">
/* START - local-weather */
.local-weather__header {
    background: #fff;
    -text-align: center;
    font-size: 16px;
    -letter-spacing: 1px;
    font-weight: 700;
    padding: 5px 0;
    border-bottom: 1px solid #e5e5e5;
}

.local-weather__title {
    line-height: 2.2;
}

.local-weather__main {
    padding: 0 10px;
    -border: 5px solid #fff;
    background: #fff;
}

.local-weather__main-item {
    border-bottom: 2px solid #fff;
    padding: 10px 0;
    line-height: 1.1;
    color: #969696;
    min-height: 5em;
}

.local-weather__main-item:last-child {
    border-bottom: none;
}

.local-weather__grad-num {
    font-size: 24px;
}

.local-weather__grad-icon {
    font-size: 18px;
    text-align: top;
}

.weather-forecast {
    display: flex;
    justify-content: space-around;
}

.weather-forecast__content span {
    font-weight: 700;
}

/* END - local-weather */

.shared-weather {
    margin: 0 0 20px;
    border: 1px solid #dbdbdb;
    /*box-shadow: 0 0 1px rgba(0, 0, 0, 0.17);*/
    background: white;
    border-radius: 3px;
}

/* Icons */
/* icons*/
.icon-w {
    font-size: 0.7em;
    position: relative;
    display: inline-block;
    top: 1em;
    /*width: 12em;
        height: 7.1em;
        font-size: 1em;*/
    /* control icon size here */
}

.cloud {
    position: absolute;
    z-index: 1;
    top: 50%;
    left: 50%;
    width: 3.6875em;
    height: 3.6875em;
    margin: -1.84375em;
    background: #e5e5e5;
    border-radius: 50%;
    box-shadow: -2.1875em 0.6875em 0 -0.6875em #e5e5e5,
        2.0625em 0.9375em 0 -0.9375em #e5e5e5,
        0 0 0 0.375em #fff,
        -2.1875em 0.6875em 0 -0.3125em #fff,
        2.0625em 0.9375em 0 -0.5625em #fff;
}

.cloud:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: -0.5em;
    display: block;
    width: 4.5625em;
    height: 1em;
    background: #e5e5e5;
    box-shadow: 0 0.4375em 0 -0.0625em #fff;
}

.cloud:nth-child(2) {
    z-index: 0;
    background: #fff;
    box-shadow: -2.1875em 0.6875em 0 -0.6875em #fff,
        2.0625em 0.9375em 0 -0.9375em #fff,
        0 0 0 0.375em #fff,
        -2.1875em 0.6875em 0 -0.3125em #fff,
        2.0625em 0.9375em 0 -0.5625em #fff;
    opacity: 0.3;
    transform: scale(0.5) translate(6em, -3em);
    animation: cloud 4s linear infinite;
}

.cloud:nth-child(2):after {
    background: #fff;
}

.sun {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 2.3em;
    height: 2.3em;
    margin: -1.25em;
    background: rgba(0, 0, 0, .0);
    border-radius: 50%;
    box-shadow: 0 0 0 0.375em #ffc700;
    animation: spin 12s infinite linear;
}

.rays {
    position: absolute;
    top: -2em;
    left: 50%;
    display: block;
    width: 0.375em;
    height: 1.125em;
    margin-left: -0.1875em;
    background: #ffc700;
    border-radius: 0.25em;
    box-shadow: 0 5.375em #ffc700;
}

.rays:before,
.rays:after {
    content: '';
    position: absolute;
    top: 0em;
    left: 0em;
    display: block;
    width: 0.375em;
    height: 1.125em;
    transform: rotate(60deg);
    transform-origin: 50% 3.25em;
    background: #ffc700;
    border-radius: 0.25em;
    box-shadow: 0 5.375em #ffc700;
}

.rays:before {
    transform: rotate(120deg);
}

.cloud+.sun {
    margin: -2em 1em;
}

.rain,
.lightning,
.snow {
    position: absolute;
    z-index: 2;
    top: 50%;
    left: 50%;
    width: 3.75em;
    height: 3.75em;
    margin: 0.375em 0 0 -2em;
    -background: #e5e5e5;
}

.rain:after {
    content: '';
    position: absolute;
    z-index: 2;
    top: 50%;
    left: 50%;
    width: 1.125em;
    height: 1.125em;
    margin: -1em 0 0 -0.25em;
    background: #0cf;
    border-radius: 100% 0 60% 50% / 60% 0 100% 50%;
    box-shadow: 0.625em 0.875em 0 -0.125em rgba(255, 255, 255, 0.2),
        -0.875em 1.125em 0 -0.125em rgba(255, 255, 255, 0.2),
        -1.375em -0.125em 0 rgba(255, 255, 255, 0.2);
    transform: rotate(-28deg);
    animation: rain 3s linear infinite;
}

.bolt {
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -0.25em 0 0 -0.125em;
    color: #fff;
    opacity: 0.3;
    animation: lightning 2s linear infinite;
}

.bolt:nth-child(2) {
    width: 0.5em;
    height: 0.25em;
    margin: -1.75em 0 0 -1.875em;
    transform: translate(2.5em, 2.25em);
    opacity: 0.2;
    animation: lightning 1.5s linear infinite;
}

.bolt:before,
.bolt:after {
    content: '';
    position: absolute;
    z-index: 2;
    top: 50%;
    left: 50%;
    margin: -1.625em 0 0 -1.0125em;
    border-top: 1.25em solid transparent;
    border-right: 0.75em solid;
    border-bottom: 0.75em solid;
    border-left: 0.5em solid transparent;
    transform: skewX(-10deg);
}

.bolt:after {
    margin: -0.25em 0 0 -0.25em;
    border-top: 0.75em solid;
    border-right: 0.5em solid transparent;
    border-bottom: 1.25em solid transparent;
    border-left: 0.75em solid;
    transform: skewX(-10deg);
}

.bolt:nth-child(2):before {
    margin: -0.75em 0 0 -0.5em;
    border-top: 0.625em solid transparent;
    border-right: 0.375em solid;
    border-bottom: 0.375em solid;
    border-left: 0.25em solid transparent;
}

.bolt:nth-child(2):after {
    margin: -0.125em 0 0 -0.125em;
    border-top: 0.375em solid;
    border-right: 0.25em solid transparent;
    border-bottom: 0.625em solid transparent;
    border-left: 0.375em solid;
}

.flake:before,
.flake:after {
    content: '\2744';
    position: absolute;
    top: 50%;
    left: 50%;
    margin: -1.025em 0 0 -1.0125em;
    color: #fff;
    list-height: 1em;
    opacity: 0.2;
    animation: spin 8s linear infinite reverse;
}

.flake:after {
    margin: 0.125em 0 0 -1em;
    font-size: 1.5em;
    opacity: 0.4;
    animation: spin 14s linear infinite;
}

.flake:nth-child(2):before {
    margin: -0.5em 0 0 0.25em;
    font-size: 1.25em;
    opacity: 0.2;
    animation: spin 10s linear infinite;
}

.flake:nth-child(2):after {
    margin: 0.375em 0 0 0.125em;
    font-size: 2em;
    opacity: 0.4;
    animation: spin 16s linear infinite reverse;
}

/* Animations */

@keyframes spin {
    100% {
        transform: rotate(360deg);
    }
}

@keyframes cloud {
    0% {
        opacity: 0;
    }

    50% {
        opacity: 0.3;
    }

    100% {
        opacity: 0;
        transform: scale(0.5) translate(-200%, -3em);
    }
}

@keyframes rain {
    0% {
        background: #0cf;
        box-shadow: 0.625em 0.875em 0 -0.125em rgba(255, 255, 255, 0.2),
            -0.875em 1.125em 0 -0.125em rgba(255, 255, 255, 0.2),
            -1.375em -0.125em 0 #0cf;
    }

    25% {
        box-shadow: 0.625em 0.875em 0 -0.125em rgba(255, 255, 255, 0.2),
            -0.875em 1.125em 0 -0.125em #0cf,
            -1.375em -0.125em 0 rgba(255, 255, 255, 0.2);
    }

    50% {
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0.625em 0.875em 0 -0.125em #0cf,
            -0.875em 1.125em 0 -0.125em rgba(255, 255, 255, 0.2),
            -1.375em -0.125em 0 rgba(255, 255, 255, 0.2);
    }

    100% {
        box-shadow: 0.625em 0.875em 0 -0.125em rgba(255, 255, 255, 0.2),
            -0.875em 1.125em 0 -0.125em rgba(255, 255, 255, 0.2),
            -1.375em -0.125em 0 #0cf;
    }
}

@keyframes lightning {
    45% {
        color: #fff;
        background: #fff;
        opacity: 0.2;
    }

    50% {
        color: #0cf;
        background: #0cf;
        opacity: 1;
    }

    55% {
        color: #fff;
        background: #fff;
        opacity: 0.2;
    }
}
</style>
