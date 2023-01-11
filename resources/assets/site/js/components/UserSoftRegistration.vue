<template>
    <form v-on:submit.prevent="onSubmit">
        <div class="form-group">
            <label for="soft-email_1" class="col-form-label">Email: <span style="color: red;">*</span>
                <i v-if="emailXhr" class="fa fa-spinner fa-pulse fa-fw"></i>
            </label>
            <input type="email" name="email" v-model="email" class="form-control"
                   @change="xhrEmailCheck($event.target.value)"
                   :class="{'is-valid': emailValid, 'is-invalid': emailInvalid}"
                   id="soft-email_1" autocomplete="email" required>
            <small v-if="emailMsg" class="form-text alert alert-danger">{{emailMsg}}</small>
        </div>


        <div class="form-group">
            <label for="soft_mobile_phone_1" class="col-form-label">{{localization['Mobile number']}}: <span
                    style="color: red;">*</span></label>
            <tel-input
                    v-model="mobile_phone"
                    :value="mobile_phone"
                    :placeholder="localization['Mobile number']"
                    :state = "phoneFailed? 'invalid' : 'is-valid'"
                    :stateFeedback = "phoneFailed? 'Invalid phone' : 'is-valid'"

            >
            </tel-input>

        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input name="terms" type="checkbox" class="custom-control-input is-invalid" id="terms" v-model="terms"
                       required>
                <label class="custom-control-label custom-control-sm" data-toggle="tooltip" data-placement="top"
                       data-html="true" data-trigger="click hover focus" for="terms"><span
                        v-html="localization.terms"></span></label>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-primary btn-block" :disabled="registered || registerXhr">
                {{localization['continue']}}
                <i v-if="registerXhr" class="fa fa-spinner fa-pulse fa-fw"></i>
            </button>
        </div>
    </form>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    import {parseNumber, isValidNumber} from 'libphonenumber-js'

    export default {
        props: [
            'regTrans',
            'countriesCodes',
            'show',
            'defaultCode',
            'emailCheckRoute',
            'localization',
            'postRegistration'
        ],
        data() {
            return {
                terms: false,
                email: null,
                emailValid: false,
                emailInvalid: false,
                emailMsg: null,
                emailXhr: false,
                registerXhr: false,
                registered: false,
                mobile: null,
                country_code: null,
                country: '',
                number: '',
                phone_number: {
                    country: null,
                    number: null
                },

                phoneIsInInterFormat: null,
                phoneFailed: false,
                localCountries: [],
                selectCode: '',
                countries: [],

                mobile_phone: ""
            }
        },
        methods: {
            countrySelect() {
                this.$refs.input_mobile.focus();
            },
            countryNameFormatter(string) {
                var str = string.toLowerCase();
                return str.charAt(0).toUpperCase() + str.slice(1);
            },
            customLabel({name, dial_code}) {
                return `${name} ${dial_code}`
            },
            isNumber(evt) {
                evt = (evt) ? evt : window.event;
                let charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },
            numberValidate() {
                if (this.phone_number.country && this.phone_number.number) {
                    let str = this.phone_number.country.dial_code + '' + this.phone_number.number;
                    if (isValidNumber(str, this.phone_number.country.code)) {
                        this.phoneFailed = false;
                        this.phoneIsInInterFormat = true;

                        this.mobile = parseNumber(str, this.phone_number.country.code);
                    } else {
                        this.phoneFailed = true;
                        this.phoneIsInInterFormat = false;
                        this.mobile = null;
                    }
                }

            },
            onSubmit() {
                // if (this.phoneIsInInterFormat && this.xhrEmailCheck(this.email)) {
                if (this.phoneIsInInterFormat && this.emailValid && this.terms) {

                    this.registerXhr = true;
                    var self = this;
                    axios.post(this.postRegistration, {
                        email: this.email,
                        //mobile: this.phone_number.country.dial_code + this.phone_number.number
                        mobile: this.mobile_phone
                    })
                        .then(function (response) {

                            console.log(response.data);
                            console.log(response.data.success);
                            console.log(response.data.msg);

                            if (response.data.success) {
                                self.$toasted.show(response.data.msg, {
                                    type: 'success'
                                });
                                self.registered = true;

                                self.$emit('soft-registration:success',
                                    {email: self.email, mobile: self.mobile_phone
                                        //mobile: self.phone_number.country.dial_code + self.phone_number.number
                                    });
                            }
                        })
                        .catch(function (error) {
                            console.log(error);

                            if (error.response.data.errors) {
                                if (error.response.data.errors.email) {
                                    self.emailMsg = error.response.data.errors.email[0]
                                }
                            }
                            // if (error.response.data.errors.mobile) {
                            //     self.backendErrors.mobile = error.response.data.errors.mobile[0]
                            // }

                            // return
                        })
                        .finally(function () {
                            self.registerXhr = false;
                        });
                    return true;
                }
                return false;
            },
            xhrEmailCheck(email) {
                self = this;
                self.emailInvalid = false;
                self.emailValid = false;
                this.emailXhr = true;
                axios.get(this.emailCheckRoute, {params: {email: email}})
                    .then(function (response) {
                        if (response.data.success) {
                            self.emailInvalid = false;
                            self.emailValid = true;
                            if (response.data.msg) self.emailMsg = response.data.msg; else self.emailMsg = null;
                        } else {
                            self.emailInvalid = true;
                            if (response.data.msg) self.emailMsg = response.data.msg;
                        }
                    })
                    .catch(function (error) {
                        self.emailInvalid = true;
                        self.emailValid = false;
                        if (error.data.message) self.emailMsg = error.data.message;
                        console.log(error);
                    })
                    .finally(function () {
                        self.emailXhr = false;
                    });
                return this.emailValid;
            }

        },
        watch: {
            "phone_number.country": function (val) {
                this.numberValidate();
            },
            "phone_number.number": function (val) {
                this.numberValidate();
            },
            "mobile_phone" : function () {
                var phoneno = /^\+?([0-9]{12})$/;
                if (this.mobile_phone.match(phoneno)) {
                    this.phoneFailed = false;
                    this.phoneIsInInterFormat = true;
                } else {
                    this.phoneFailed = true;
                    this.phoneIsInInterFormat = false;
                }
            }
        },
        components: {
            Multiselect
        },
        created() {
            for (let item in this.countriesCodes) {
                this.countries.push({
                    code: item,
                    dial_code: "+" + this.countriesCodes[item].code,
                    name: this.countryNameFormatter(this.countriesCodes[item].name)
                });
            }
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>

    .flag-box {
        display: inline-block;
        margin-right: 6px;
    }

    .soft_country-code .multiselect__content-wrapper {
        width: 400px;
    }

    .soft_country-code .option__image-span {
        display: inline-block;
        width: 14px;
        height: 10px;
        background-size: cover;
    }

    .soft_country-code .multiselect__tags {
        text-align: right;
        min-height: 45px;
        line-height: 1.5;
        min-width: 140px;
        padding-top: 11px;
        border-radius: 5px 0 0 5px;
        cursor: pointer;

    }

    .soft_country-code.is-valid .multiselect__tags {
        border-color: #28a745;
    }

    .soft_country-code.is-invalid .multiselect__tags {
        border-color: #d90202;
    }

    .soft_country-code .multiselect {
        width: 140px;
    }
    .soft_country-code__phone{
        font-size: 16px;
        padding: 8px;
    }
</style>
