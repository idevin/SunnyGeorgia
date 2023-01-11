<template>
    <div class="m-portlet m-portlet--head-solid-bg m-portlet--success">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <span class="m-portlet__head-icon">
                            <i class="flaticon-comment"></i>
                        </span>
                        <h3 class="m-portlet__head-text">
                            Ваш отзыв
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="form-group form-group-last">
                    <label>Оценка</label>
                    <star-rating v-model="rating"
                                 :show-rating="false"
                                 :star-size="40"
                    ></star-rating>
                </div>
<!--                <div class="form-group form-group-last">-->
<!--                    <label>Заголовок</label>-->
<!--                    <input class="form-control m-input"-->
<!--                           type="text"-->
<!--                           v-model="title"-->
<!--                    >-->
<!--                </div>-->
                <div class="form-group form-group-last">
                    <label>Отзыв</label>
                    <limited-textarea v-model="review"
                                      :max="2000"
                                      :rows="10"
                                      placeholder="Поделитесь своими впечатлениями"
                    ></limited-textarea>
                </div>
            </div>
            <div class="m-portlet__foot">
                <button class="btn btn-primary"
                        :class="{disabled: !review || !rating}"
                        @click="send"
                >Опубликовать</button>
                <button class="btn btn-secondary"
                        :class="{disabled: !review && !rating}"
                        @click="reset"
                >Сбросить</button>
            </div>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating'
    import LimitedTextarea from "../../../shared-components/LimitedTextarea";
    export default {
        name: 'product-review',
        components: {
            LimitedTextarea,
            StarRating
        },
        props: {
            productId: {
                type: Number,
                default: null
            },
            productType: {
                type: String,
                default: null
            },
            reviewData: {
                type: Object,
                default: null
            }
        },
        data: () => ({
            rating: null,
            review: null,
            // title: null
        }),
        methods: {
            send () {
                if(this.rating && this.review){
                    // todo вынести в API класс
                    axios.post(`/cabinet/review/${this.productType}/${this.productId}`, {
                            rating: this.rating,
                            review: this.review,
                            // title: this.title
                        })
                        .then((response) => {
                            if(response.data) this.$toasted.success('отзыв опубликован');
                            console.log(response.data)
                        })
                        .catch((error) => {
                            this.$toasted.error(error.response.data.message);
                            console.log(error.response.data)
                        })
                }
            },
            reset() {
                this.rating = null;
                this.review = null
            }
        },
        mounted() {
            if(this.reviewData) {
                this.rating = this.reviewData.rating;
                this.review = this.reviewData.body;
                // this.title = this.reviewData.title;
            }
        }
    }
</script>

<style scoped>
    .disabled {
        cursor: not-allowed;
    }
</style>
