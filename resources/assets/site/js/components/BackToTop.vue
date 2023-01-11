<template>
    <button class="goTop" v-if="isVisible" @click="backToTop">
        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="angle-up" role="img"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-angle-up fa-w-10 fa-3x">
            <path fill="currentColor"
                  d="M168.5 164.2l148 146.8c4.7 4.7 4.7 12.3 0 17l-19.8 19.8c-4.7 4.7-12.3 4.7-17 0L160 229.3 40.3 347.8c-4.7 4.7-12.3 4.7-17 0L3.5 328c-4.7-4.7-4.7-12.3 0-17l148-146.8c4.7-4.7 12.3-4.7 17 0z"
                  class=""></path>
        </svg>
    </button>
</template>

<script>
    export default {
        name: 'back-to-top',
        data: function () {
            return {
                isVisible: false
            };
        },
        methods: {
            initToTopButton: function () {
                $(document).bind('scroll', function () {
                    var backToTopButton = $('.goTop');
                    if ($(document).scrollTop() > 250) {
                        backToTopButton.addClass('isVisible');
                        this.isVisible = true;
                    } else {
                        backToTopButton.removeClass('isVisible');
                        this.isVisible = false;
                    }
                }.bind(this));
            },
            backToTop: function () {
                $('html,body').stop().animate({
                    scrollTop: 0
                }, 'slow', 'swing');
            }
        },
        mounted: function () {
            this.$nextTick(function () {
                this.initToTopButton();
            });
        }
    }
</script>