<template>
    <div v-if="feedingAvailability">
        <span class="h3 d-block mb-2 text-black text-transform-none">{{localization['Food']}}:</span>
        <ul v-if="feedingAvailability && !loading" class="list-unstyled conditions-check">
            <li v-for="(opt, index) in feedingOptionsList">
                <label :for="index" class="checkbox checkbox-primary">

                    <input
                            type="radio"
                            :id="opt.id"
                            :data-foodtype="opt.title"
                            :data-foodprice="opt.local_price"
                            class="checkbox-field"
                            name="testname"
                            :value="index" @change="onRadioChange"
                            :checked="opt.id == defaultSelectedFeedingId">

                    <span class="checkbox-label"></span>
                    <span class="check-text">{{ opt.title }}</span>
                    <span v-if="opt.local_price != 0 && opt.local_price !== null" class="check-text check-count">{{ opt.local_price }} {{ currency.code }} {{localization['persons']}}</span>
                </label>
            </li>
        </ul>
        <div v-if="!feedingAvailability && !loading" class="color-blue">{{localization['Unavailable']}}</div>
        <shared-loader v-if="loading"></shared-loader>
    </div>
</template>

<script>
    export default {
        props: ['localization'],
        computed: {
            loading () {
                return this.$store.getters.loading
            },
            feedingOptionsList () {
                return this.$store.getters.feedingOptionsList
            },
            currency () {
                return this.$store.getters.currency
            },
            feedingAvailability () {
                return this.$store.getters.feedingAvailability
            },
            feedingFreeExist () {
                return this.$store.getters.feedingFreeExist
            },
            feedingFreeId () {
                return this.$store.getters.feedingFreeId
            },
            feedingSelectedId () {
                return this.$store.getters.feedingSelectedId
            },
            defaultSelectedFeedingId () {
                return this.$store.getters.defaultSelectedFeedingId
            }
        },
        methods: {
            onRadioChange (event) {
                this.$store.dispatch('receiveSelectedFeedingId', event.target.value)
                this.$store.dispatch('receiveSelectedFeedingPrice', event.target.dataset.foodprice ? event.target.dataset.foodprice : 0)
                this.$store.dispatch('receiveSelectedFeedingType', event.target.dataset.foodtype)
                this.$store.dispatch('receiveTourTotalPrice')
            }
        },
    }
</script>

<style>
    .local-price {
        font-size: 10px;
    }
    .local-price__inner {
        color: green;
        font-weight: 700;
        font-size: 14px;
    }
</style>