<template>
    <div class="gallery-swiper">
        <!-- swiper1 -->
        <swiper :options="swiperOptionTop" class="gallery-top" ref="swiperTop">
            <swiper-slide v-for="(image, index) in slider" :key="index + 'top'">
                <picture class="gallery-swiper__picture">
                    <source type="image/webp"
                            :srcset="setSrcset(image.webp)"
                            sizes="
                                (min-width: 1200px) 825px,
                                (max-width: 1200px) and (min-width: 992px) 690px,
                                (max-width: 992px) and (min-width: 768px) 690px,
                                (max-width: 768px) and (min-width: 576px) 510px,
                                345px
                            "
                    >
                    <source type="image/jpeg"
                            :srcset="setSrcset(image.jpeg)"
                            sizes="(min-width: 1200px) 825px,
                                    (min-width: 992px) 690px,
                                    (min-width: 768px) 510px,
                                    (min-width: 576px) 345px"
                    >
                    <img class="gallery-swiper__img"
                         :src="image.origin" :alt="`slide ${index+1}`"
                    >
                </picture>
            </swiper-slide>
            <div class="swiper-button-next swiper-button-white"
                 slot="button-next"></div>
            <div class="swiper-button-prev swiper-button-white"
                 slot="button-prev"></div>
        </swiper>
        <swiper :options="swiperOptionThumbs"
                class="gallery-thumbs"
                ref="swiperThumbs"
        >
            <swiper-slide v-for="(image, index) in thumbs" :key="index + 'thumb'">
                <picture class="gallery-thumbs-swiper__picture">
                    <source type="image/webp"
                            :srcset="image.webp"
                    >
                    <img class="gallery-thumbs-swiper__img"
                         :src="image.origin"
                         :alt="`slide ${index+1} thumb`"
                    >
                </picture>
            </swiper-slide>
        </swiper>
    </div>
</template>

<script>
    import { swiper, swiperSlide } from 'vue-awesome-swiper'
    import 'swiper/dist/css/swiper.css'
    export default {
        name: "ProductGallery",
        components: {
            swiper,
            swiperSlide
        },
        props: {
            slider: Array,
            thumbs: Array
        },
        data() {
            return {
                swiperOptionTop: {
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
                },
                swiperOptionThumbs: {
                    spaceBetween: 10,
                    slidesPerView: 4,
                    touchRatio: 0.2,
                    loop: true,
                    loopedSlides: 5,
                    slideToClickedSlide: true,
                },
            }
        },
        mounted() {
            this.$nextTick(() => {
                const swiperTop    = this.$refs.swiperTop.swiper;
                const swiperThumbs = this.$refs.swiperThumbs.swiper;

                swiperTop.controller.control    = swiperThumbs;
                swiperThumbs.controller.control = swiperTop;
            });
        },
        methods: {
            setSrcset(source) {
                let result = '';
                let counter = 1;
                for (let prop in source) {
                    if(counter !== 1) {
                        result += ', '
                    }
                    result += `${source[prop]} ${prop}`;
                    counter ++;
                }
                return result;
            }
        },
    }
</script>

<style scoped>
    .gallery-swiper {
        height: 300px;
    }

    .gallery-swiper__picture, .gallery-thumbs-swiper__picture {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .gallery-swiper__img, .gallery-thumbs-swiper__img {
        height: 100%;
        position: absolute;
    }
    @media (min-width: 576px) {
        .gallery-swiper {
            height: 508px;
        }
        .gallery-swiper__img {
            width: 100%;
            height: auto;
        }
    }

    .swiper-button-prev {
        left: 20px;
    }

    .swiper-button-next {
        right: 20px;
    }

    .gallery-top {
        height: 80% !important;
        width: 100%;
    }

    .gallery-thumbs {
        height: 20% !important;
        box-sizing: border-box;
        padding: 10px 0 0;
    }

    .gallery-thumbs .swiper-slide {
        width: 25%;
        height: 100%;
        cursor: pointer;
        overflow: hidden;
    }

    @media (max-width: 544px) {
        .gallery-swiper {
            height: 300px;
        }

        .gallery-thumbs {
            padding: 6px 0;
        }
    }
</style>
