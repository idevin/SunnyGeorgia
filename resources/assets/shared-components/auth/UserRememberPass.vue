<template>
    <div>
        <div v-if="successful === false">
            <div class="form-group">
                <div class="form-label"><span class="required_star">*</span>{{'auth.email' | trans}}</div>
                <div class="form-input">
                    <input type="text"
                           :class="{error: validation.hasError('email')}"
                           v-model="email"
                           placeholder="example@gmail.com"
                           name="email"
                    >
                    <div class="validation-error-text">
                        <span v-if="notValid">{{'auth.no email'|trans}}</span>
                        <span v-else>{{validation.firstError('email') }}</span>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <shared-loader v-if="sending"></shared-loader>
                <button v-else
                        class="register-btn"
                        :class="{disabled: validation.hasError() || !email}"
                        @click="check"
                >{{'auth.get link' | trans}}
                </button>
            </div>
        </div>
        <div v-else>
            <div class="form-group">
                <p class="text-center">
                    {{'auth.password reset link txt' | trans}}
                </p>
            </div>
            <div class="form-group text-right">
                <shared-loader v-if="sending"></shared-loader>
                <button v-else
                        class="register-btn"
                        @click="$store.commit('authModalTab', '')"
                >Ok</button>
            </div>
        </div>
    </div>
</template>

<script>
    import ApiAuth from '../../api/Auth'
    import SimpleVueValidator from 'simple-vue-validator';
    import SharedLoader from '../../shared-components/SharedLoader.vue'
    import ruValidator from '../../ru-validator'
    import geValidator from '../../ge-validator'

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
                default: 'ru/password/email'
            },
        },
        data() {
            return {
                email: '',
                successful: false,
                notValid: false,
                sending: false
            }
        },
        validators: {
            email: function (value) {
                return Validator.value(value).required().email();
            }
        },
        methods: {
            check() {
                if (!this.validation.hasError()) {
                    this.$validate();
                }
                if(!this.sending) {
                    if (!this.validation.hasError()) {
                        ApiAuth.checkEmail({email: this.email})
                            .then((resp) => {
                                this.notValid = false;
                                this.send();
                            })
                            .catch(error => {
                                this.notValid = true
                            })
                    }
                }
            },
            send() {
                this.sending = true;
                axios.post(this.route, {email: this.email})
                    .then(resp => {
                        this.successful = true;
                        this.sending = false
                    })
                    .catch(error => {
                        this.successful = false;
                        this.sending = false
                    })
            },
        }
    }
</script>

<style scoped>
    .form-group {
        margin-bottom: 20px;
        font-size: 16px
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
        color: #767676;
    }

    button.register-btn:hover.disabled {
        cursor: not-allowed !important;
        background: none;
        color: #767676;
    }

    .form-group button {
        width: 100%
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
</style>
