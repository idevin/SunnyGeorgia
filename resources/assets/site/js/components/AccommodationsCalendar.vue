<template>
    <div class="accommodations-calendar bg-gray">
        <div class="text-center accommodations-calendar__step">
            <h3 class="h2 text-black mb-0"><span class="">1.</span> {{localization['Start date of the tour']}}:</h3>
        </div>
        <div class="accommodations-calendar__wrapper">
            <v-calendar
                    is-double-paned
                    :attributes='attributes'
                    @dayclick='dayClicked'
            ></v-calendar>
        </div>
        <ul class="list-unstyled calendar-help">
            <li class="available">
                {{localization['There are empty seats']}}
            </li>
            <li class="selected">
                {{localization['Date selected']}}
            </li>
        </ul>
    </div>
</template>

<script>
    var moment = require('moment')

    export default {
        props: ['localization'],
        data() {
            return {
                selectedDate: null,
                attributes: [
                    {
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
                        dates: null
                    },
                    {
                        key: 'current',
                        highlight: {
                            backgroundColor: '#ffc411',
                            backgroundBorder: '#ffc411',
                            borderColor: '#ffc411',
                            borderRadius: '4px'
                        },
                        contentStyle: {
                            color: '#000',
                        },
                        dates: null
                    }
                ]
            }
        },
        computed: {
            availableAccommodationsDates () {
                return this.$store.getters.availableAccommodationsDates
            },
            accommodationDate () {
                return this.$store.getters.accommodationDate
            },
            currentDate () {
                return this.$store.getters.currentDate
            },
            tomorrowDate () {
                return this.$store.getters.tomorrowDate
            },
            availableDates () {
                return this.$store.getters.availableDates
            }
        },
        methods: {
            setAvailableDates (payload) {
                this.attributes[0].dates = payload
            },
            setCurrentDay (payload) {
                this.attributes[1].dates = payload
            },
            dayClicked (day) {
                var current = new Date()
                current = current.setHours(0,0,0,0)
                if (day.dateTime < current) {
                    this.$toasted.error(this.localization['Only upcoming dates can be selected'])
                } else {
                    this.$store.dispatch('receiveCurrentDate', moment(day.date).format('YYYY-MM-DD'))
                    this.setCurrentDay(this.currentDate)
                    this.$store.dispatch('receiveTourTotalPrice')
                }
            }
        },
        created () {
            let self = this
            document.addEventListener("DOMContentLoaded", function(){
                var tomorrow = moment().add(1, 'days')
                var tomorrowInRightFormat = tomorrow.format('YYYY-MM-DD')
                self.$store.dispatch('receiveTomorrowDate', moment())
                self.$store.dispatch('receiveCurrentDate', tomorrowInRightFormat)
                self.$store.dispatch('receiveAvailableDates')
                self.setAvailableDates(self.availableDates)
                self.setCurrentDay(self.tomorrowDate)
            })
        }
    }
</script>

<style lang="scss">
    .accommodations-calendar {
        display: flex;
        flex-flow: column;
        border-top: 2px solid #dbdbdb;
    }
    .accommodations-calendar__wrapper {
        width: auto;
        text-align: center;
        margin: auto;
        background-color: #f6f6f6;
        padding: 20px;
        border: 1px solid #dbdbdb;
        border-radius: 3px;
    }

    .accommodations-calendar__step {
        margin-top: 15px;
        margin-bottom: 10px;
    }

    .c-pane-container {
        background-color: #f6f6f6 !important;
        border: none !important;
    }

    .calendar-help {
        justify-content: center;
    }

    .c-day-content-wrapper .c-day-content {
        cursor: pointer !important;
        font-size: 15px;
        font-weight: inherit;
        line-height: normal;
        margin: 5px;
    }


    @media (min-width: 543px) {
        // START: убрать стрелочки с календаря
        .c-pane-container {
            position: relative;

            .c-pane {
                position: static;
            }

            .c-pane:first-child {

                .c-arrow-layout:first-child {
                    display: none;
                }

                .c-arrow-layout:last-child {
                    position: absolute;
                    top: 1px;
                    right: 10px;
                }
            }

            .c-pane:last-child {

                .c-arrow-layout:last-child {
                    display: none;
                }

                .c-arrow-layout:first-child {
                    position: absolute;
                    top: 2px;
                    left: 10px;
                }
            }

            .c-header {
                padding: 0px 0px 15px 0px;
            }

            .c-section-wrapper {
                position: static;
            }

            .c-vertical-divider {
                display: none;
            }
        }
        // END: убрать стрелочки с календаря
    }
</style>
