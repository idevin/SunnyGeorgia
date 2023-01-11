<template>
    <div class="user-registration-steps">
        <div v-show="currentStep === 1" class="user-registration-steps__item">
            <form class="form" @submit.prevent="validateStepOne('form-1')" data-vv-scope="form-1">
                <div class="form__item form-group">
                    <label for="email" class="col-form-label">{{ trans.email }}</label>
                    <input
                            class="form-control"
                            :class="{'input': true, 'is-danger': errors.has('form-1.email') }"
                            type="email"
                            name="email"
                            id="email"
                            v-model="stepOneData.email"
                            v-validate="'required|email'"
                    >
                    <div v-if="backendErrors.email" class="help is-danger">{{ backendErrors.email }}</div>
                    <div v-show="errors.has('form-1.email')" class="help is-danger">{{ errors.first('form-1.email') }}</div>
                </div>
                <div class="form__item form-group">
                    <label for="password" class="col-form-label">{{ trans.password }}</label>
                    <input
                            class="form-control"
                            :class="{'input': true, 'is-danger': errors.has('form-1.password') }"
                            type="password"
                            name="password"
                            id="password"
                            v-model="stepOneData.password"
                            v-validate data-vv-rules="required"
                    >
                    <div v-if="backendErrors.password" class="help is-danger">{{ backendErrors.password }}</div>
                    <div v-show="errors.has('form-1.password')" class="help is-danger">{{ errors.first('form-1.password') }}</div>
                </div>
                <div class="form__item form-group">
                    <label for="confirm-password" class="col-form-label">{{ trans.repeat_password }}</label>
                    <input
                            class="form-control"
                            :class="{'input': true, 'is-danger': errors.has('form-1.confirm-password') }"
                            type="password"
                            name="confirm-password"
                            id="confirm-password"
                            v-model="stepOneData.confirmPassword"
                            v-validate="'required|confirmed:password'"
                    >
                    <div v-show="errors.has('form-1.confirm-password')" class="help is-danger">{{ errors.first('form-1.confirm-password') }}</div>
                </div>
                <div class="form__item form-group">
                    <div class="custom-control custom-checkbox">
                        <input name="terms" type="checkbox" class="custom-control-input is-invalid" id="terms" v-model="stepOneData.terms" v-validate="'required'">
                        <label class="custom-control-label custom-control-sm" data-toggle="tooltip" data-placement="top" data-html="true" data-trigger="click hover focus" for="terms"><span v-html="trans.terms"></span></label>
                    </div>
                    <div v-show="errors.has('form-1.terms')" class="help is-danger">{{ errors.first('form-1.terms') }}</div>
                </div>
                <div class="form__item form-group d-flex justify-content-end">
                    <button
                            class="btn btn-outline-primary"
                            type="submit"
                    >{{ trans.continue }}</button>
                </div>
            </form>
        </div>
        <div v-show="currentStep === 2" class="user-registration-steps__item">
            <form class="form" @submit.prevent="validateStepTwo('form-2')" data-vv-scope="form-2">
                <div class="form__item form-group" v-html="trans.phone_label_description"></div>
                <div class="form__item form-group country-code">
                    <span :class="'country-code__img flag flag-icon-' + (selectFlagUrl.toLowerCase())"></span>
                    <span @click="onSelectCodeClick" class="country-code__select-code">{{selectCode}}</span>
                    <multiselect
                            ref="multiselect"
                            id="mobile_code"
                            v-model="stepTwoData.code"
                            label="dial_code"
                            name="mobile_code"
                            placeholder="+ code"
                            :searchable="true"
                            :options="countries"
                            :show-labels="false"
                            :custom-label="customLabel"
                            @input="onCodeInput"
                            track-by="name">
                        <template
                                slot="option"
                                slot-scope="props">
                            <span :class="'option__image-span flag flag-icon-' + (props.option.code.toLowerCase())"></span>
                            <div class="option__desc">
                                <span class="option__title">{{ props.option.name }}</span>
                                <span class="option__small">{{ props.option.dial_code }}</span>
                            </div>
                        </template>
                    </multiselect>
                    <input
                            type="tel"
                            class="form-control country-code__phone"
                            :class="{'is-danger': !phoneIsInInterFormat, 'is-valid': phoneIsInInterFormat}"
                            id="mobile_phone"
                            name="mobile_phone"
                            v-model="stepTwoData.tel"
                            v-validate="'required|regex:^\\+?\\d+$'"
                            @keypress="isNumber"
                            placeholder="Phone number">
                    <div v-if="backendErrors.tel" class="help is-danger">{{ backendErrors.tel }}</div>
                    <div v-show="errors.has('form-2.mobile_phone')" class="help is-danger">{{ errors.first('form-2.mobile_phone') }}</div>
                </div>
                <div class="form__item form-group d-flex justify-content-end">
                    <button
                            class="btn btn-outline-primary"
                            :disabled="!phoneIsInInterFormat"
                            type="submit"
                    >{{ trans.continue }}</button>
                </div>
            </form>
            <form v-if="showSMS" class="form" @submit.prevent="validateStepThree('form-3')" data-vv-scope="form-3">
                <div class="form__item form-group">
                    <label for="signup-code" class="col-form-label">{{ trans.enter_code_from_sms }}</label>
                    <input
                            class="form-control"
                            :class="{'input': true, 'is-danger': errors.has('form-3.signup-code') }"
                            type="text"
                            name="signup-code"
                            id="signup-code"
                            v-model="stepThreeData.smsCode"
                            v-validate="'required'"
                            required
                    >
                    <div v-if="backendErrors.smsCode" class="help is-danger">{{ backendErrors.smsCode }}</div>
                    <div v-show="errors.has('form-3.signup-code')" class="help is-danger">{{ errors.first('form-3.signup-code') }}</div>
                </div>
                <div class="form__item form-group d-flex justify-content-end">
                    <button
                            class="btn btn-outline-primary"
                            type="submit"
                    >{{ trans.complete_registration }}</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import { parseNumber, isValidNumber } from 'libphonenumber-js'

    export default {
        props: ['regTrans', 'countriesCodes'],
        data() {
            return {
                phoneIsInInterFormat: null,
                localCountries: [],
                showSMS: false,
                selectCode: '',
                defaultSelectCode: "GE",
                selectFlagUrl: 'ge',
                trans: undefined,
                currentStep: 1,
                stepOneData: {
                    email: "",
                    password: "",
                    confirmPassword: "",
                    terms: false,
                },
                stepTwoData: {
                    tel: "",
                    code: {}
                },
                stepThreeData: {
                    smsCode: ""
                },
                backendErrors: {
                    email: '',
                    password: '',
                    tel: '',
                    smsCode: ''
                },
                countries: null,
            }
        },
        methods: {
            countryNameFormatter (string) {
                var str = string.toLowerCase();
                return str.charAt(0).toUpperCase() + str.slice(1);
            },

            isNumber (evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },

            onSelectCodeClick () {
                this.$refs.multiselect.$el.focus()
            },

            onCodeInput (val) {
                if (val) {
                    this.selectCode = val.dial_code
                }
            },

            customLabel ({ name, dial_code }) {
                return `${name} ${dial_code}`
            },

            validateStepOne (scope) {
                const self = this;
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        axios.post('/register', {
                            email: this.stepOneData.email,
                            password: this.stepOneData.password,
                            password_confirmation: this.stepOneData.confirmPassword
                        })
                            .then(function (response) {
                                self.currentStep++
                                return
                            })
                            .catch(function (error) {
                                if (error.response.data.errors.email) {
                                    self.backendErrors.email = error.response.data.errors.email[0]
                                } else if (error.response.data.errors.password) {
                                    self.backendErrors.password = error.response.data.errors.password[0]
                                }
                                return
                            })
                    } else {
                        return
                    }
                })
            },
            validateStepTwo (scope) {
                const self = this;
                var mobileNumber = parseNumber(this.stepTwoData.code.dial_code + '' + this.stepTwoData.tel, this.stepTwoData.code.code)
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        axios.get('/cabinet/confirm-send', {
                            params: {
                                mobile_phone: mobileNumber.phone,
                                mobile_code: this.stepTwoData.code.dial_code
                            }
                        })
                            .then(function (response) {
                                self.showSMS = true
                                return
                            })
                            .catch(function (error) {
                                if (error.response.data.errors.mobile_phone) {
                                    self.backendErrors.tel = error.response.data.errors.mobile_phone[0]
                                }
                                return
                            });
                    } else {
                        return
                    }
                })
            },
            validateStepThree (scope) {
                const self = this;
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        axios.get('/cabinet/confirm-check', {
                            params: {
                                code: this.stepThreeData.smsCode
                            }
                        })
                            .then(function (response) {
                                location.reload()
                                return
                            })
                            .catch(function (error) {
                                if (!error.response.data.success) {
                                    self.backendErrors.smsCode = 'Incorrect sms password.'
                                }
                                return
                            });
                    } else {
                        return
                    }
                })
            }
        },
        components: {
            Multiselect
        },
        watch: {
            "stepTwoData.code": function (val) {
                var str = this.stepTwoData.code.dial_code + '' + this.stepTwoData.tel
                if (isValidNumber(str, this.stepTwoData.code.code)) {
                    this.phoneIsInInterFormat = true
                } else {
                    this.phoneIsInInterFormat = false
                }
                if(val) {
                    this.selectFlagUrl = val.code.toLowerCase()
                }
            },
            "stepTwoData.tel": function (val) {
                var str = this.stepTwoData.code.dial_code + '' + val
                if (isValidNumber(str, this.stepTwoData.code.code)) {
                    this.phoneIsInInterFormat = true
                } else {
                    this.phoneIsInInterFormat = false
                }
            }
        },
        created() {
            this.localCountries = JSON.parse(this.countriesCodes)
            var countriesReformedArray = [];
            for (let item in this.localCountries) {
                countriesReformedArray.push({
                    code: item,
                    dial_code: "+" + this.localCountries[item].code,
                    name: this.countryNameFormatter(this.localCountries[item].name)
                })
            }
            this.countries = countriesReformedArray;

            this.trans = JSON.parse(this.regTrans)

            for (let item in this.countries) {
                if(this.countries[item].code === this.defaultSelectCode) {
                    this.stepTwoData.code = this.countries[item]
                    this.selectFlagUrl = this.countries[item].code.toLowerCase()
                    this.selectCode = this.countries[item].dial_code
                }
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .country-code__select-code {
        position: absolute;
        top: 1px;
        left: 33px;
        z-index: 1;
        width: 61px;
        line-height: 39px;
        text-align: right;
        height: 38px;
        background: #fff;
        border-radius: 5px;
        overflow: hidden;
    }

    .is-danger {
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #d90202;
    }

    input.is-danger {
        color: #495057;
        background-color: #fff;
        border-color: #d90202;
        outline: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #fde908;
        outline: 0;
        box-shadow: none;
    }

    .country-code {
        position: relative;
        padding-left: 138px;
    }

    .country-code__img {
        position: absolute;
        top: 11px;
        left: 0;
        width: 22px;
        height: 17px;
        background-size: cover;
    }

    .form-control {
        padding: 8px 10px 9px;
        border: 1px solid #e8e8e8;
        font-size: 14px;
        color: #000;
    }

    .country-code .multiselect__content-wrapper {
        width: 306px;
    }

    .country-code .multiselect__option {
        position: relative;
    }

    .country-code .option__desc {
        padding-left: 29px;
    }
    .country-code .option__image-span {
        position: absolute;
        top: 11px;
        left: 10px;
        width: 22px;
        height: 17px;
        background-size: cover;
    }

    .country-code .multiselect {
        position: absolute;
        top: 0;
        left: 32px;
        width: 100px;
    }

    .country-code .multiselect__input {
        text-align: right;
    }

    @media screen and (max-width: 480px) {
        .country-code .multiselect__content-wrapper {
            width: 200px;
        }
    }
</style>