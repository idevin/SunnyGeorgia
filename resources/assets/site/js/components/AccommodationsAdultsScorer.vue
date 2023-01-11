<template>
    <div>
        <input v-if="!loading && isAvailable && price > 0" class="w-100" type="number" min="0" max="9999" v-model="adults">
        <div v-if="!loading && !isAvailable">{{localization['Unavailable']}}</div>
        <shared-loader v-if="loading"></shared-loader>
    </div>
</template>

<script>
    export default {
        props: ['accid', 'accAdults', 'accKids', 'accAddBeds', 'localization'],
        data() {
            return {
                isAvailable: false,
                adults: "",
                price: 0,
                localExactPrice: {
                    adults: null,
                    kids: null,
                    additional: null
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
            singleAccommodation () {
                return this.$store.getters.singleAccommodation(this.accid)
            },
            exactPrice () {
                return this.$store.getters.exactPrice
            }
        },
        methods: {
            getAvailable(currentDate) {
                let self = this
                let flag = false
                for (let i in self.singleAccommodation.available) {
                    if (currentDate == self.singleAccommodation.available[i].date && self.singleAccommodation.available[i].amount > 0) {
                        flag = true
                    }
                }
                self.isAvailable = flag
            },
            getExactPrice(accID) {
                let adultPriceEl,
                    kidPriceEl,
                    additionalPriceEl

                adultPriceEl = document.getElementById('acom_' + accID + '_price_adult')
                kidPriceEl = document.getElementById('acom_' + accID + '_price_kid')
                additionalPriceEl = document.getElementById('acom_' + accID + '_price_additional')

                if (adultPriceEl === null) {
                    this.localExactPrice.adults = 0
                } else {
                    this.localExactPrice.adults = parseFloat(adultPriceEl.dataset.price)
                }

                if (kidPriceEl === null) {
                    this.localExactPrice.kids = 0
                } else {
                    this.localExactPrice.kids = parseFloat(kidPriceEl.dataset.price)
                }

                if (additionalPriceEl === null) {
                    this.localExactPrice.additional = 0
                } else {
                    this.localExactPrice.additional = parseFloat(additionalPriceEl.dataset.price)
                }
            },
            getLocPrice(accID) {
                this.price = this.exactPrice[accID].adults
            }
        },
        watch: {
            adults() {
                this.$store.dispatch('receiveTourAccomm', {
                    id: this.accid,
                    value: this.adults,
                    name: 'adults'
                })
                this.$store.dispatch('receiveTourTotalPrice')
                this.$store.dispatch('receiveTotalPersons')
            },
            currentDate() {
                this.getAvailable(this.currentDate)
            }
        },
        created () {
            let self = this
            document.addEventListener("DOMContentLoaded", function(){
                self.getAvailable(self.currentDate)
                self.getExactPrice(self.accid)
                self.$store.dispatch('receiveExactPrice', {
                    id: self.accid,
                    value: {
                        adults: self.localExactPrice.adults,
                        kids: self.localExactPrice.kids,
                        additional: self.localExactPrice.additional
                    }
                })
                self.getLocPrice(self.accid)
            })
        }
    }
</script>