<template>
    <div>
        <input v-if="!loading && isAvailable && price > 0" class="w-100" type="number" min="0" max="9999" v-model="kids">
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
                kids: "",
                price: 0
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
            getLocPrice(accID) {
                this.price = this.exactPrice[accID].kids
            }
        },
        watch: {
            kids() {
                this.$store.dispatch('receiveTourAccomm', {
                    id: this.accid,
                    value: this.kids,
                    name: 'kids'
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
                self.getLocPrice(self.accid)
            })
        }
    }
</script>