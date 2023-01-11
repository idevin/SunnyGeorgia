import Vue       from 'vue';
import Component from 'vue-class-component';

import './gallery-swiper.scss';

@Component({
    template: require('./gallery-swiper.html'),
    props: {
        imagesData: Array,
    }
})
export class GallerySwiper extends Vue {
    // Props
    imagesData;

    // Data
    images = this.imagesData;

    swiperOptionTop = {
        effect: 'fade',
        autoplay: {
            delay: 5000,
        },
        spaceBetween: 10,
        loop: true,
        loopedSlides: 5,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        }
    };

    swiperOptionThumbs = {
        spaceBetween: 10,
        slidesPerView: 4,
        touchRatio: 0.2,
        loop: true,
        loopedSlides: 5,
        slideToClickedSlide: true,
    };


    mounted() {
        this.$nextTick(() => {
            const swiperTop    = (<any>this.$refs.swiperTop).swiper;
            const swiperThumbs = (<any>this.$refs.swiperThumbs).swiper;

            swiperTop.controller.control    = swiperThumbs;
            swiperThumbs.controller.control = swiperTop;
        });
    }

    imageStyle (img) {
        return 'background-image: url("' + img.url + '")';
    }
}
