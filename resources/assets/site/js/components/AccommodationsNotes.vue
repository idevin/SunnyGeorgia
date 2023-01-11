<template>
    <div class="accommodations-notes mb-4">
        <span class="h3 d-block mb-2 text-black text-transform-none">{{localization['Add message to the order']}}:</span>
        <textarea class="form-control" name="notes" cols="30" rows="10" v-model="notes"></textarea>
    </div>
</template>

<script>
    export default {
        props: ['localization'],
        data() {
            return {
                notes: ''
            }
        },
        watch: {
            notes(newVal) {
                this.$store.dispatch('receiveNotes', newVal)
            }
        },
    }
</script>