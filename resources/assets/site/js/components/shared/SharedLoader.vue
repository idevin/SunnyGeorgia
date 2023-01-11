<template>
    <div class="shared-loader">
        <fulfilling-bouncing-circle-spinner
                :animation-duration="4000"
                :size="30"
                color="#FFC411"
        />
    </div>
</template>

<script>
    import { FulfillingBouncingCircleSpinner   } from 'epic-spinners'

    export default {
        data() {
            return {
                msg: "Load it please"
            }
        },
        components: {
            FulfillingBouncingCircleSpinner
        }
    }
</script>

<style lang="scss">
    .shared-loader {
        display: inline-block;
        color: #ccc;
    }
</style>