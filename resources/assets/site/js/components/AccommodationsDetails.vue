<template>
    <div class="mb-4">
        <span class="h3 text-black d-block font-weight-bold">{{localization['Order details']}}:</span>
        <div v-if="!loading" class="result-text">
            <ul class="list-unstyled">
                <li>{{localization['Date']}}: <strong v-show="currentDate">{{ readableDate }}</strong></li>
                <li><strong>{{ tourDays }}</strong> {{localization['days and']}} <strong>{{ tourNights }}</strong> {{localization['nights']}}</li>
                <li>{{localization['Adults']}}: <b>{{ totalPersons.adults }}</b></li>
                <li v-if="totalPersons.kids > 0">{{localization['Kids']}}: <b>{{ totalPersons.kids }}</b></li>
                <li v-if="totalPersons.additional > 0">{{localization['Extras. beds']}}: <b>{{ totalPersons.additional }}</b></li>
                <li v-if="transferIncluded === true || transferPrice">
                    {{localization['Transfer']}}:
                    <span v-if="transferIncluded === true"><strong>{{localization['enter in cost']}}</strong></span>
                    <span v-if="transferIncluded === false && !transferChecked"><strong>{{localization['not enter']}}</strong></span>
                    <span v-if="transferIncluded === false && transferChecked"><strong>{{localization['Enabled additionally']}}</strong> (+{{ transferPrice }} {{ currency.code }})</span>
                </li>
                <li v-if="feedingAvailability && !feedingSelectedType">{{localization['Type of food']}}: <strong>{{localization['undefined']}}</strong></li>
                <li v-if="feedingAvailability && feedingSelectedType">{{localization['Type of food']}}: <strong>{{ feedingSelectedType }}</strong></li>
            </ul>
        </div>
        <shared-loader v-if="loading"></shared-loader>
    </div>
</template>

<script>
    var moment = require('moment')

    export default {
        props: ['localization'],
        methods: {
            receiveTotalPersons(obj) {
                for (let i in obj) {
                    console.log(obj[i])
                }
            }
        },
        computed: {
            loading () {
                return this.$store.getters.loading
            },
            currentDate () {
                return this.$store.getters.currentDate
            },
            accommodationQuery () {
                return this.$store.getters.accommodationQuery
            },
            foodType () {
                return this.$store.getters.foodType
            },
            foodPrice () {
                return this.$store.getters.foodPrice
            },
            readableDate () {
                return moment(this.currentDate).format('DD.MM.YY')
            },
            localCurrency () {
                return this.$store.getters.localCurrency
            },
            foodOptions () {
                return this.$store.getters.foodOptions
            },
            // new
            currency () {
                return this.$store.getters.currency
            },
            tourAdults () {
                return this.$store.getters.tourAdults
            },
            tourChildren () {
                return this.$store.getters.tourChildren
            },
            transferPrice () {
                return this.$store.getters.transferPrice
            },
            transferChecked () {
                return this.$store.getters.transferChecked
            },
            transferIncluded () {
                return this.$store.getters.transferIncluded
            },
            feedingSelectedType () {
                return this.$store.getters.feedingSelectedType
            },
            feedingSelectedPrice () {
                return this.$store.getters.feedingSelectedPrice
            },
            feedingAvailability () {
                return this.$store.getters.feedingAvailability
            },
            tourDays () {
                return this.$store.getters.tourDays
            },
            tourNights () {
                return this.$store.getters.tourNights
            },
            totalPersons () {
                return this.$store.getters.totalPersons
            }
        },
    }
</script>