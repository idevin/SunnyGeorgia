<template>
    <div class="aside-map" v-if="center.lat && center.lng">
        <gmap-map
                :center="center"
                :zoom="14"
                style="width: 100%; height: 300px"
        >
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
        props: ['placeData'],
        data () {
            return {
                place: this.placeData
            }
        },
        computed: {
            center: function() {
                return {
                    lat: Number(this.place.lat),
                    lng: Number(this.place.long)
                };
            }
        }
    }
</script>

<style lang="scss" scoped>
    .aside-map {
        margin: 0 0 20px;
        border: 1px solid #dbdbdb;
        /*box-shadow: 0 0 1px rgba(0, 0, 0, 0.17);*/
        border-radius: 3px;
    }

    .aside-map__header {
        background: #fff;
        text-align: center;
        font-size: 18px;
        letter-spacing: 1px;
        font-weight: 700;
        padding: 5px 0;
    }
</style>
