<template>
    <div class="page-tour-show">
        <v-tour name="myTour" :steps="steps" :options="options" :callbacks="callbacks"></v-tour>
    </div>
</template>

<script>
    export default {
        props: ['previousUrl'],
        data () {
            return {
                currentStep: 1,
                steps: [
                    {
                        target: '.btn--info',
                        content: `Вы находитесь здесь, на странице общей информации по туру.`,
                        params: {
                            placement: 'bottom'
                        }
                    },
                    {
                        target: '.btn--accomodations',
                        content: `В этой вкладке вы можете заполнить список размещений.<br>Сейчас он пуст.`,
                        params: {
                            placement: 'bottom'
                        }
                    },
                    {
                        target: '.btn--calendar',
                        content: `В этой вкладке вы можете заполнить календарь доступности туров для бронирования.<br>Сейчас он пуст.`,
                        params: {
                            placement: 'bottom'
                        }
                    },
                    {
                        target: '.image-uploader__zone',
                        content: `Здесь вы можете загрузить фотографии для превью и галереи тура.`,
                        params: {
                            placement: 'top'
                        }
                    }
                ],
                callbacks: {
                    onPreviousStep: this.onPrevStep,
                    onNextStep: this.onNextStep
                },
                options: {
                    useKeyboardNavigation: false
                }
            }
        },
        mounted: function () {
            if ((location.protocol + "//" + location.hostname + "/cabinet/partner/tours/create") == this.previousUrl) {
                this.$tours['myTour'].start()
            }
        },
        methods: {
            onPrevStep () {
                var $wrapper = $('.v-tour');
                this.currentStep--;

                if (this.currentStep === 2) {
                    setTimeout( () => {
                        $wrapper.find('.v-step').removeClass().addClass('v-step').addClass('v-step--2');
                    }, 10 )
                }
                if (this.currentStep === 3) {
                    setTimeout( () => {
                        $wrapper.find('.v-step').removeClass().addClass('v-step').addClass('v-step--3');
                    }, 10 )
                }
            },

            onNextStep () {
                var $wrapper = $('.v-tour');
                this.currentStep++;

                if (this.currentStep === 2) {
                    setTimeout( () => {
                        $wrapper.find('.v-step').removeClass().addClass('v-step').addClass('v-step--2');
                    }, 10 )
                }
                if (this.currentStep === 3) {
                    setTimeout( () => {
                        $wrapper.find('.v-step').removeClass().addClass('v-step').addClass('v-step--3');
                    }, 10 )
                }
            }
        }
    }
</script>

<style>
    .v-step {
        z-index: 8;
    }
    .v-step[x-placement^=bottom].v-step--2 .v-step__arrow {
        left: calc(61% - 1rem);
    }
    .v-step[x-placement^=bottom].v-step--3 .v-step__arrow {
        left: calc(81.5% - 1rem);
    }
</style>