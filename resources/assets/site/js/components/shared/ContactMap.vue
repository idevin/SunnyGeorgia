<template>
    <div class="contact-map">
        <gmap-map
                :center="center"
                :zoom="14"
                style="width: 100%; height: 400px"
        >
            <gmap-marker :position="marker"></gmap-marker>
        </gmap-map>
    </div>
</template>

<script>
    import Vue from 'vue';
    import * as VueGoogleMaps from 'vue2-google-maps'

    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyB84qmY3DStcvSENCRaIKvYnAgpZ_h99VY'
        }
    });

    export default {
        data () {
            return {
                center: {
                    lat: 41.650067,
                    lng: 41.632254
                },
                marker: {
                    lat: 41.650067,
                    lng: 41.632254
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .contact-map {
        width: 100%;
        min-height: 400px;
        margin-bottom: -20px;
    }
</style>