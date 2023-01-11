<template>
    <div v-if="transferIncluded || transferPrice">
        <div class="check-text h3 d-block mb-2 text-black text-transform-none">{{localization['Transfer']}}:</div>
        <div v-if="transferIncluded && !loading">
            <div class="checkbox checkbox-primary align-items-start m-0 color-blue">{{localization['Added to price']}}</div>
        </div>
        <label v-if="!transferIncluded && !loading" for="transfer" class="checkbox checkbox-primary align-items-start m-0">
            <input id="transfer" type="checkbox" class="checkbox-field" v-model="checked">
            <span class="checkbox-label"></span>
            <span class="check-text">{{localization['Add to price']}}<br>
                <span class="price price-sale">
                    <strong>+{{ transferPrice }} {{ currency.code }}</strong>
                </span>
            </span>
        </label>
        <shared-loader v-if="loading"></shared-loader>
    </div>
</template>

<script>
    export default {
        props: ['localization'],
        data() {
            return {
                checked: false
            }
        },
        computed: {
            loading () {
                return this.$store.getters.loading
            },
            currency () {
                return this.$store.getters.currency
            },
            transferPrice () {
                return this.$store.getters.transferPrice
            },
            transferIncluded () {
                return this.$store.getters.transferIncluded
            },
            transferChecked () {
                return this.$store.getters.transferChecked
            }
        },
        watch: {
            transferChecked (value) {
                this.checked = value
                this.$store.dispatch('receiveTourTotalPrice')
            },
            checked (value) {
                this.$store.dispatch('setTransferChecked', value)
                this.$store.dispatch('receiveTourTotalPrice')
            }
        },
    }
</script>

<style scoped>
    .color-blue {
        color: #0e4061;
    }

    .price.price-sale strong {
        font-size: 16px;
        font-weight: 400;
    }
</style>