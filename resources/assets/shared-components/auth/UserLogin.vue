<template>
    <div>
        <div v-if="excursionInProcess || tourInProcess" class="form-group auth-modal__before-order-text">
            {{'auth.you must login or register' | trans}}
        </div>
        <div class="form-group">
            <div class="form-label"><span class="required_star">*</span>{{'auth.email' | trans}}</div>
            <div class="form-input">
                <input :class="{error: validation.hasError('email')}"
                       type="email"
                       placeholder="example@gmail.com"
                       name="email"
                       v-model="email"
                >
                <div class="validation-error-text">{{ validation.firstError('email') }}</div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label"><span class="required_star">*</span>{{'auth.password'|trans}}</div>
            <div class="form-input">
                <input :class="{error: validation.hasError('password')}"
                       type="password"
                       ref="password"
                       v-model="password"
                       :placeholder="'auth.password'|trans"
                       name="password"
                >
                <div class="validation-error-text">{{ validation.firstError('password') }}</div>
            </div>
        </div>
        <div class="form-group">
            <div class="text-information">
               <span class="link"
                     @click="$emit('remember-pass')"
               >{{'auth.forgot password?'|trans}}</span>
            </div>
        </div>
        <div class="form-group">
            <div class="validation-error-text" v-if="serverErrors.length">
                <span v-for="error in serverErrors">{{error}}<br></span>
            </div>
        </div>
        <div class="form-group text-right">
            <shared-loader v-if="sending"></shared-loader>
            <button v-else
                    class="register-btn"
                    :class="{disabled: validation.hasError() || (!email && !password)}"
                    @click="submit"
            >{{'auth.login' | trans}}</button>
        </div>
    </div>
</template>

<script>
    import SimpleVueValidator from 'simple-vue-validator'
    import ruValidator from '../../ru-validator'
    import geValidator from '../../ge-validator'
    import SharedLoader from '../../shared-components/SharedLoader.vue'

    if (window.Laravel.locale === 'ru') {
        SimpleVueValidator.extendTemplates(ruValidator);
    }
    if (window.Laravel.locale === 'ka') {
        SimpleVueValidator.extendTemplates(geValidator);
    }
    SimpleVueValidator.setMode('conservative');
    const Validator = SimpleVueValidator.Validator;

    export default {
        mixins: [SimpleVueValidator.mixin],
        components: {SharedLoader},
        props: {
            route: {
                type: String,
                default: 'login'
            },
        },
        data() {
            return {
                password: '',
                email: '',
                serverErrors: [],
                sending: false
            }
        },
        methods: {
            submit() {
                if(!this.validation.hasError()) {
                    this.$validate();
                }
                if(!this.sending) {
                    if (!this.validation.hasError()) {
                        this.login()
                    }
                }
            },
            login() {
                this.sending = true;
                axios.post(this.route, {
                    password: this.password,
                    email: this.email.toLowerCase(),
                    remember: true
                }).then(resp => {
                    this.$store.dispatch('receiveUser', resp.data.user);
                    if (this.tourInProcess || this.excursionInProcess) {
                        let action = this.tourInProcess ? 'sendTourOrder' : 'sendExcursionOrder';
                        this.$gtm.trackEvent({
                            event: 'GAEvent',
                            category: 'Booking ' + this.productType,
                            action: 'log_in_success',
                            label: this.email,
                        });
                        if (! this.user.mobile_number || ! this.user.mobile_confirmed) {
                            this.$store.commit('authModalTab', 'confirm-phone');
                            this.$gtm.trackEvent({
                                event: 'GAEvent',
                                category: 'Booking ' + this.productType,
                                action: 'confirm_phone_to_book',
                                label: this.email,
                            });
                        } else {
                            this.$store.dispatch(action).then(() => {
                                this.$store.commit('authModalTab', 'product-accepted');
                                this.$gtm.trackEvent({
                                    event: 'GAEvent',
                                    category: 'Booking ' + this.productType,
                                    action: 'finish',
                                });
                            });
                        }
                    } else {
                        this.$store.commit('authModalTab', '')
                    }
                }).catch(error => {
                    this.sending = false;
                    this.serverErrors = [];
                    if(error.response && error.response.data) {
                        for (let item in error.response.data.errors) {
                            if (error.response.data.errors.hasOwnProperty(item)) {
                                this.serverErrors.push(error.response.data.errors[item][0])
                            }
                        }
                    } else if(error.response) {
                        this.serverErrors.push(error.response)
                    } else {
                        window.location.reload()
                    }

                })
            }
        },
        computed: {
            excursionInProcess() {
                if(this.$store.state.excursion) {
                    return this.$store.state.excursion.excursionInProcess
                }
            },
            tourInProcess() {
                if(this.$store.state.tour) {
                    return this.$store.state.tour.tourInProcess
                }
            },
            user() {
                return this.$store.getters.user
            },
            productType() {
                if (this.tourInProcess || this.excursionInProcess) {
                    return this.tourInProcess ? 'tour' : 'excursion';
                }
            }
        },
        validators: {
            email: function (value) {
                return Validator.value(value).required().email();
            },
            password: function (value) {
                return Validator.value(value).required().minLength(6);
            },
        },
    }
</script>

<style scoped>
    .form-group {
        position: relative;
        margin-bottom: 20px;
        font-size: 16px
    }

    .form-group:first-child {
        margin-top: 20px;
    }

    input {
        border: 1px solid #f2f2f2;
        border-radius: 3px;
        outline: none;
        height: 45px;
        line-height: 45px;
        padding: 0 18px;
        width: 100%;
        background: #fff;
        font-size: 14px;
    }

    input.error, input:focus.error {
        border-color: #d90102;
        box-shadow: 0 2px 5px rgba(217, 1, 2, 0.2)
    }

    input:focus {
        border-color: #fde908;
        box-shadow: 0 2px 5px rgba(253, 233, 8, 0.2)
    }

    button.register-btn {
        border: 1px solid #ffc412;
        border-radius: 3px;
        height: 45px;
        line-height: 45px;
        padding: 0 30px;
        background: #fff;
        cursor: pointer;
        outline: none;
        font-weight: bold;
        transition: all ease .3s;
    }

    button.register-btn:hover {
        background: #ffc412;
        color: #fff;
    }

    button.register-btn:hover.disabled {
        cursor: not-allowed !important;
        background: none;
        color: #767676;
    }

    .text-information {
        font-size: 12px;
        color: #767676;
    }

    .validation-error-text {
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
    }

    .required_star {
        color: #dc3545;
        margin-right: 2px;
    }

    .auth-modal__before-order-text {
        margin-top: 0!important;
        /* margin-left: -30px; */
        /* margin-right: -30px; */
        text-align: center;
    }

    @media (max-width: 576px) {
        .form-group{
            padding-left:50px
        }
    }
</style>
