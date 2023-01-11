<template>
        <div class="ml-lg-4 mb-4">
            <span class="h3 d-block mb-2 text-black text-transform-none">Укажите количество взрослых и детей:</span>
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="quantity-primary">
                        <div class="quantity-item flex-column align-items-start">
                            <span class="h4 d-block mb-2 text-black text-transform-none">Взрослые:</span>
                            <div class="quantity ml-0">
                                <span class="quantity-arrows minus" @click.prevent="decrementAdults">-</span>
                                <input type="number" class="qty" :value="tourAdults" readonly>
                                <span class="quantity-arrows plus" @click.prevent="incrementAdults">+</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="quantity-primary">
                        <div class="quantity-item flex-column align-items-start">
                            <span class="h4 d-block mb-2 text-black text-transform-none">Дети: (до 16 лет)</span>
                            <div class="quantity ml-0">
                                <span class="quantity-arrows minus" @click.prevent="decrementChildren">-</span>
                                <input type="number" class="qty" :value="tourChildren" readonly>
                                <span class="quantity-arrows plus" @click.prevent="incrementChildren">+</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                minCount: 1,
                maxCount: 500
            }
        },
        computed: {
            tourAdults () {
                return this.$store.getters.tourAdults
            },
            tourChildren () {
                return this.$store.getters.tourChildren
            }
        },
        methods: {
            incrementAdults () {
                let result = parseInt(this.tourAdults)
                if (result < this.maxCount) {
                    result++
                    this.$store.dispatch('receiveTourAdults', result)
                    this.$store.dispatch('receiveTourTotalPrice')
                }
            },
            decrementAdults () {
                let result = parseInt(this.tourAdults)
                if (result >= this.minCount) {
                    result--
                    this.$store.dispatch('receiveTourAdults', result)
                    this.$store.dispatch('receiveTourTotalPrice')
                }
            },
            incrementChildren () {
                let result = parseInt(this.tourChildren)
                if (result < this.maxCount) {
                    result++
                    this.$store.dispatch('receiveTourChildren', result)
                    this.$store.dispatch('receiveTourTotalPrice')
                }
            },
            decrementChildren () {
                let result = parseInt(this.tourChildren)
                if (result >= this.minCount) {
                    result--
                    this.$store.dispatch('receiveTourChildren', result)
                    this.$store.dispatch('receiveTourTotalPrice')
                }
            }
        }
    }
</script>