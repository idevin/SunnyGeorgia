<template>
    <div class="bug-reporter" :class="{ active : active }">
        <div v-if="sending" class="bug-reporter__state" style="text-align: center;">
            <shared-loader></shared-loader>
        </div>
        <div v-if="!sending" class="bug-reporter__state">
            <header class="bug-reporter__header">
                <button type="button" class="bug-reporter__button" @click="toggleForm">
                    <i class="bug-reporter__button-icon m-menu__link-icon fa fa-bug"></i>
                </button>
            </header>
            <div class="bug-reporter__main">
                <form class="bug-reporter-form" @submit.prevent="onSubmit">

                    <div class="bug-reporter-form__item">
                        <strong>Сообщить об ошибке в работе сайта</strong>
                    </div>
                    <div class="bug-reporter-form__item">
                        <p>Убедитесь что вы именно на той странице где была замечена ошибка в работе сайта</p>
                    </div>
                    <div class="bug-reporter-form__item">
                        <label class="bug-reporter-form__label" for="bugReportActual">Ожидалось:</label>
                        <textarea
                                class="bug-reporter-form__field"
                                id="bugReportActual"
                                v-model="expectedResult"
                                required
                        ></textarea>
                    </div>
                    <div class="bug-reporter-form__item">
                        <label class="bug-reporter-form__label" for="bugReportExpected">Получилось:</label>
                        <textarea
                                class="bug-reporter-form__field"
                                id="bugReportExpected"
                                v-model="actualResult"
                                required
                        ></textarea>
                    </div>
                    <div class="bug-reporter-form__item">
                        <button
                                :disabled="!formIsValid"
                        >Отправить
                        </button>
                    </div>
                    <div class="bug-reporter-form__item">
                        <small>* Все поля обязательны для заполнения</small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['formAction'],
        data() {
            return {
                sending: false,
                active: false,
                page: '',
                actualResult: '',
                expectedResult: '',
                userAgent: '',
                screenWidth: '',
                screenHeight: ''
            }
        },
        computed: {
            formIsValid() {
                return this.actualResult !== '' && this.expectedResult !== ''
            }
        },
        methods: {
            toggleForm() {
                this.active = !this.active
            },

            onSubmit() {
                var self = this
                self.sending = true
                const bug = {
                    page: this.page,
                    actual_result: this.actualResult,
                    expected_result: this.expectedResult,
                    user_agent: this.userAgent,
                    screen_width: this.screenWidth,
                    screen_height: this.screenHeight
                }
                axios.post(self.formAction, bug)
                    .then((response) => {
                        self.$toasted.success('Баг репорт успешно отправлен')
                    })
                    .catch((error) => {
                        self.$toasted.error(error)
                    })
                    .finally(() => {
                        self.sending = false;
                        self.active = false;
                    })
            }
        },
        created() {
            this.page = window.location.href
            this.userAgent = window.navigator.userAgent
            this.screenWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
            this.screenHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0)
        }
    }
</script>

<style lang="scss">

    .bug-reporter {
        position: fixed;
        width: 300px;
        top: 25%;
        right: -305px;
        background: #f5f5f5;
        box-sizing: border-box;
        padding: 20px 20px;
        border: 1px solid #ccc;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }

    .bug-reporter.active {
        right: 5px;
    }

    .bug-reporter__button {
        width: 33px;
        height: 33px;
        margin: 0;
        padding: 0;
        border: none;
        cursor: pointer;
        background: #eaeaea;
    }

    .bug-reporter__button:hover {
        background: #e0e0e0;
    }

    .bug-reporter__button:focus {
        outline: none;
    }

    .bug-reporter__button-icon {
        width: 33px;
        height: 33px;
        display: block;
    }

    .bug-reporter__button-icon.fa-bug:before {
        content: "\f188";
        margin-top: 0;
        width: 33px;
        height: 33px;
        display: block;
        padding-top: 9px;
        box-sizing: border-box;
    }

    .bug-reporter-form__item {
        margin: 0 0 15px;
    }

    .bug-reporter-form__item:last-child {
        margin: 0;
    }

    .bug-reporter__header {
        width: 42px;
        height: 27px;
        position: absolute;
        top: 0;
        left: -45px;
    }

    .bug-reporter-form__label {
        display: block;
    }

    .bug-reporter-form__field {
        display: block;
        width: 100%;
        box-sizing: border-box;
    }


</style>