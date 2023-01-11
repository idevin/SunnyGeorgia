<template>
    <div>
        <v-date-picker
                :attributes='attributes'
                :min-date='new Date()'
                @dayclick='dayClicked'
                v-model="currentDate"
                :select-attribute='selectedDate'
                :disabled-attribute="disabledDates"
                :theme-styles='themeStyles'
                :show-popover="false"
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
                return Object.entries(this.availability).map(day => {
                    let accommodations = day[1].map(accom => accom.accommodation_id);
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
                        customData: accommodations,
                    }
                });
            },
        },
        methods: {
            dayClicked(day) {
                if (day.attributesMap.available) {
                    this.getAccommodations(day.attributesMap.available.customData)
                    this.$emit('show-calendar', false)
                }
            },
            getAccommodations(accommodations) {
                axios.get(this.formAction, {
                    params: {accommodations: accommodations}
                }).then((response) => {
                    this.accommodations = response.data.accommodations
                }).catch(error => {
                    if (axios.isCancel(error)) {
                        console.log('Request canceled', error);
                    } else {
                        console.log(error);
                    }
                });
            }
        },
        watch: {
            accommodations(accommodations) {
                if(! this.currentDate) {
                    accommodations = [];
                }
                this.$emit('accommodations', accommodations)
            },
            currentDate(val){
                if(val) {
                    this.$emit('input', val)
                }
            }
        },
    }
</script>
