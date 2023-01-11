<template>
    <div class="p-top__rating">
        <div class="p-top__rating-item"
             v-for="fullStar in fullStars" :key="fullStar + 'full'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="15.5px" height="14.5px">
                <path fill-rule="evenodd" stroke="rgb(255, 196, 17)"
                      stroke-width="1px" stroke-linecap="butt"
                      stroke-linejoin="miter" fill="rgb(255, 196, 17)"
                      d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
            </svg>
        </div>
        <div class="p-top__rating-item"
             v-if="halfStar"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="15.5px" height="14.5px">
                <path fill-rule="evenodd" stroke="rgb(255, 196, 17)"
                      stroke-width="1px" stroke-linecap="butt"
                      stroke-linejoin="miter" fill="none"
                      d="M10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 Z"/>
                <path fill-rule="evenodd" fill="rgb(255, 196, 17)"
                      d="M3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 L7.251,11.204 L3.303,12.834 Z"/>
            </svg>
        </div>
        <div class="p-top__rating-item"
             v-for="emptyStar in emptyStars" :key="emptyStar + 'empty'"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="15.5px" height="14.5px">
                <path fill-rule="evenodd" stroke="rgb(255, 196, 17)"
                      stroke-width="1px" stroke-linecap="butt"
                      stroke-linejoin="miter" fill="none"
                      d="M7.251,0.683 L9.487,4.323 L13.639,5.324 L10.868,8.575 L11.199,12.834 L7.251,11.204 L3.303,12.834 L3.633,8.575 L0.863,5.324 L5.015,4.323 L7.251,0.683 Z"/>
            </svg>
        </div>
        <div class="p-top__rating-number">&nbsp;{{avgRating}}</div>
    </div>
</template>
<script>
export default {
    props: ['avgRating'],
    data() {
        return {
            fullStars: 0,
            emptyStars: 0,
            halfStar: 0
        }
    },
    mounted() {
        this.fullStars = Math.floor(this.avgRating);
        this.halfStar = this.avgRating - this.fullStars ? 1 : 0;
        this.emptyStars = 5 - this.fullStars - this.halfStar
    }
}
</script>
<style>
    .p-top__rating {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
</style>
