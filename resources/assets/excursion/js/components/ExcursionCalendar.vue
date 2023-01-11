<template>
    <div>
        <v-date-picker
                :attributes='attributes'
                @dayclick='dayClicked'
                v-model="currentDate"
                :select-attribute='selectedDate'
                :disabled-attribute="disabledDates"
                :available-dates="availableDates"
                :theme-styles='themeStyles'
                :show-popover="false"
                :is-required="true"
                is-inline
        ></v-date-picker>
        <div class="p-order__select-date-legend">
            <div class="p-order__select-date-legend_available">{{localization['Available']}}</div>
            <div class="p-order__select-date-legend_selected">{{localization['Selected']}}</div>
        </div>
    </div>
</template>

<script>
    import VCalendar from 'v-calendar';
    import 'v-calendar/lib/v-calendar.min.css';
    import Vue from 'vue';
    Vue.use(VCalendar, {
        firstDayOfWeek: 2,
        locale: window.Laravel.locale
    });
    export default {
        props: ['availability', 'formAction', 'localization'],
        data() {
            return {
                currentDate: null,
                availableDates: [],
                disabledDates: {
                    contentStyle: {
                        cursor: 'not-allowed',
                        color: '#989898',
                        backgroundColor: 'transparent',
                        opacity: 1
                    },
                    contentHoverStyle: {
                        cursor: 'not-allowed',
                        backgroundColor: 'transparent',
                    },
                },
                selectedDate: {
                    contentStyle: {
                        backgroundColor: '#f6c039',
                        color: '#000',
                        borderRadius: '4px',
                    },
                    contentHoverStyle: {
                        borderRadius: '4px',
                        opacity: 1,
                        backgroundColor: '#f6c039',
                        color: '#000',
                    },
                },
                themeStyles: {
                    wrapper: {
                        background: 'none',
                    }
                },
                accommodations: null,
            }
        },
        computed: {
            attributes() {
                let first = true;
                return Object.entries(this.availability).map(day => {
                    let excursionTimes = day[1].map(accom => accom.time);
                    if(first) {
                        this.currentDate = new Date(day[0]);
                        this.times = excursionTimes;
                        this.$emit('selectDay', {
                            times: this.times,
                            date: day[0]
                        });
                        first = false
                    }
                    this.availableDates.push(day[0]);
                    return {
                        key: 'available',
                        highlight: {
                            backgroundColor: '#8cd8b1',
                            backgroundBorder: '#8cd8b1',
                            borderColor: '#8cd8b1',
                            borderRadius: '4px'
                        },
                        contentStyle: {
                            color: '#000'
                        },
                        dates: day[0],
                        customData: {times: excursionTimes, date: day[0]},
                    }
                });
            },
        },
        methods: {
            dayClicked(day) {
                this.$emit('show-calendar', false);
                this.$emit('selectDay', {
                    times: day.attributesMap.available.customData.times,
                    date: day.attributesMap.available.customData.date
                });
            }
        }
    }
</script>
