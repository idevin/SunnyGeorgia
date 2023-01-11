<template>
    <div class="accommodations-rooms-count">
        <div v-if="isAvailable && !loading">
            <select v-model="selectedValue" :name="accid" style="width: 100%;" :class="{ activeselect: isSelected }" @change="onSelectChange">
                <option value="0" :selected="selectedValue">0</option>
                <option v-for="int in amount" :value="int" :selected="selectedValue">{{ int }}</option>
            </select>
        </div>
        <div v-if="!isAvailable && !moreUnavailable && !loading">Нет доступных номеров</div>
        <div v-if="moreUnavailable && !loading" class="more-unavailable">Выбранные вами номера - не доступны на эту дату</div>
        <shared-loader v-if="loading"></shared-loader>
    </div>
</template>

<script>
    export default {
        // Работает с конкретным размещением из списка размещений тура,
        // ID размещения передается входным параметром.
        props: ['accid'],
        data() {
            return {
                isAvailable: null,
                amount: null,
                isSelected: false,
                selectedValue: null,
                moreUnavailable: false
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
            accommodations () {
                return this.$store.getters.accommodations
            }

        },
        methods: {
            onSelectChange (event) {
                if (event.target.value > 0) {
                    this.$store.dispatch('receiveTourOrderedRooms', {
                        id: this.accid,
                        value: event.target.value
                    })
                    this.isSelected = true
                } else {
                    this.$store.dispatch('removeTourOrderedRooms', event.target.name)
                    this.isSelected = false
                    this.selectedValue = null
                }
                this.$store.dispatch('receiveTourTotalPrice')
            },
            getAvailable(currentDate) {
                let self = this
                let flag = false
                for (let i in self.singleAccommodation.available) {
                    if (currentDate == self.singleAccommodation.available[i].date) {
                        flag = true
                    }
                }
                self.isAvailable = flag
            },
            getAmountCount (currentDate) {
                let self = this
                for (let i in self.singleAccommodation.available) {
                    if (currentDate == self.singleAccommodation.available[i].date) {
                        self.amount = self.singleAccommodation.available[i].amount
                    }
                }
            }
        },
        watch: {
            currentDate() {
                this.getAvailable(this.currentDate)
                this.getAmountCount(this.currentDate)



                if (this.isAvailable && this.isSelected) {
                    // Дата поменялась, выбор сделан и он всё ещё доступен
                    if (this.selectedValue > this.amount) {
                        this.selectedValue = this.amount
                        this.$store.dispatch('receiveTourOrderedRooms', {
                            id: this.accid,
                            value: this.amount
                        })
                    }
                    this.moreUnavailable = false
                } else if (!this.isAvailable && this.isSelected) {
                    // Дата поменялась, выбор сделан но он более не доступен
                    this.moreUnavailable = true
                }



            }
        },
        created () {
            let self = this
            document.addEventListener("DOMContentLoaded", function(){
                self.getAvailable(self.currentDate)
                self.getAmountCount(self.currentDate)
            })
        }
    }
</script>

<style lang="scss">
    .activeselect {
        border: 1px solid green;
        background: #e2ffe8;
        font-weight: 700;
    }
    
    .more-unavailable {
        color: #ffc411;
        font-weight: 700;
    }

    .table .select-col {
        text-align: center;
        vertical-align: middle;
    }
</style>