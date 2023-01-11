<template>
    <div>
        <div v-if="excursionInProcess || tourInProcess" class="form-group auth-modal__before-order-text">
            {{'auth.you must login or register' | trans}}
        </div>
        <div class="form-group">
            <div class="form-label"><span class="required_star">*</span>{{'auth.email' | trans}}</div>
            <div class="form-input">
                <input type="email"
                       :class="{error: validation.hasError('email')}"
                       placeholder="example@gmail.com"
                       v-model.trim="email"
                       name="email"
                >
                <div class="validation-error-text">{{ validation.firstError('email') }}</div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">{{'auth.first name' | trans}}</div>
            <div class="form-input">
                <input type="text"
                       :placeholder="'auth.first name' | trans"
                       v-model="firstName"
                       name="name"
                >
            </div>
        </div>
        <div class="form-group">
            <div class="form-label">{{'auth.last name' | trans}}</div>
            <div class="form-input">
                <input type="text"
                       :placeholder="'auth.last name' | trans"
                       v-model="lastName"
                       name="last-name"
                >
            </div>
        </div>
        <!--<div class="form-group">-->
            <!--<div class="form-label">{{'auth.mobile' | trans}}</div>-->
            <!--<div class="form-input">-->
                <!--<input type="tel"-->
                       <!--:class="{error: validation.hasError('mobile')}"-->
                       <!--placeholder="+995 000 00 00"-->
                       <!--v-model.trim="mobile"-->
                       <!--name="tel"-->
                <!--&gt;-->
                <!--<div class="validation-error-text">{{ validation.firstError('mobile') }}</div>-->
            <!--</div>-->
        <!--</div>-->
        <div class="form-group">
            <div class="text-information">
                <a class="no-link"
                   :href="terms"
                   target="_blank"
                   v-html="$options.filters.trans('auth.terms')"
                ></a>
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
                    @click="submit"
                    :class="{disabled: validation.hasError() || !email}"
            >{{'auth.registration'|trans}}</button>
        </div>

    </div>
</template>

<script>
    import ApiAuth from '../../api/Auth'
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
    const locale = window.Laravel.locale;

    export default {
        components: {SharedLoader},
        mixins: [SimpleVueValidator.mixin],
        props: {
            route: {
                type: String,
                default: 'register'
            },
            terms: {
                type: String,
                default: 'ru/terms'
            },
        },
        data() {
            return {
                locale: locale,
                email: '',
                // mobile: '',
                firstName: '',
                lastName: '',
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
                        this.register()
                    }
                }
            },
            register() {
                this.sending = true;
                axios.post(this.route, {
                    email: this.email.toLowerCase(),
                    // mobile: this.mobile.split(' ').join(''),
                    'first_name': this.firstName,
                    'last_name': this.lastName
                }).then(resp => {
                    this.sending = false;
                    this.$store.dispatch('receiveUser', resp.data.user);
                    this.$emit('user-registered', resp.data.msg);
                }).catch(error => {
                    this.serverErrors = [];
                    if(error.response && error.response.data) {
                        for (let item in error.response.data.errors) {
                            this.serverErrors.push(error.response.data.errors[item][0])
                        }
                    } else if (error.response) {
                        this.serverErrors.push(error.response)
                    }
                    this.sending = false;
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
        },
        validators: {
            email: {
                debounce: 200,
                validator(value) {
                    return Validator.value(value).required().email().custom(() => {
                        if (!Validator.isEmpty(value)) {
                            return ApiAuth.checkUniqueEmail({email: this.email})
                                .then(() => {
                                })
                                .catch(() => this.$options.filters.trans('auth.email registered'))
                        }
                    });
                }
            },
            // mobile: function(value) {
            //     return Validator.value(value).minLength(4).maxLength(16);
            // },
        }
    }
</script>

<style scoped>
    .form-group {
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
        padding: 0 18px;
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

    .no-link {
        cursor: default;
        color: inherit;
        text-decoration: none;
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
