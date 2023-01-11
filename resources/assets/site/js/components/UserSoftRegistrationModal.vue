<template id="bs-modal">
    <div class="modal fade" id="softRegistrationModal" tabindex="-1" role="dialog" aria-labelledby="remind-modalLabel"
         data-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <svg class="icon icon--close" width="32px" height="32px" @click="clickClose">
                        <use xlink:href="#close"></use>
                    </svg>

                </button>
                <div class="modal-header">
                    <h5 class="modal-title">{{localization['Fast registration']}}</h5>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <p>{{localization['We will register account for your and add your booking there']}}</p>
                            <form v-on:submit.prevent="onSubmit">
                                <div class="form-group">
                                    <label for="soft-email" class="col-form-label">Email: <span style="color: red;">*</span>
                                        <i v-if="emailXhr" class="fa fa-spinner fa-pulse fa-fw"></i>
                                    </label>
                                    <input type="email" name="email" v-model="email" class="form-control"
                                           @change="xhrEmailCheck($event.target.value)"
                                           :class="{'is-valid': emailValid, 'is-invalid': emailInvalid}"
                                           id="soft-email" autocomplete="email" required>
                                    <small v-if="emailMsg" class="form-text text-muted">{{emailMsg}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="soft_mobile_phone" class="col-form-label">{{localization['Mobile number']}}: <span style="color: red;">*</span></label>
                                    <div class="input-group ">

                                        <div class="input-group-prepend">
                                            <multiselect class="soft_country-code" v-model="phone_number.country"

                                                         :options="countries"
                                                         :custom-label="customLabel"
                                                         :placeholder="localization['country']"

                                                         label="name"
                                                         @select="countrySelect"
                                                         :class="{'is-invalid': !phoneIsInInterFormat, 'is-valid': phoneIsInInterFormat}"

                                                         track-by="name">

                                                <template slot="singleLabel" slot-scope="{ option }">
                                                    <div class="flag-box">
                                                        <span :class="'option__image-span flag flag-icon-' + (option.code.toLowerCase())"></span>
                                                    </div>
                                                    <span class="option__title">{{ option.dial_code}}</span>
                                                </template>

                                                <template slot="option" slot-scope="props">
                                                    <div class="option__desc">
                                                        <div class="flag-box">
                                                            <span :class="'option__image-span flag flag-icon-' + (props.option.code.toLowerCase())"></span>
                                                        </div>

                                                        <span class="option__title">{{ props.option.name }}</span>
                                                        <span class="option__small">{{ props.option.dial_code }}</span>
                                                    </div>
                                                </template>
                                            </multiselect>
                                        </div>
                                        <input
                                                ref="input_mobile"
                                                type="tel"
                                                class="form-control soft_country-code__phone"
                                                :class="{'is-invalid': !phoneIsInInterFormat, 'is-valid': phoneIsInInterFormat}"
                                                id="soft_mobile_phone"
                                                name="soft_mobile_phone"
                                                v-model="phone_number.number"
                                                autocomplete="tel-national"
                                                @keypress="isNumber"
                                                :placeholder="localization['Mobile number']" required>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-outline-primary btn-block">{{localization['continue']}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    import {parseNumber, isValidNumber} from 'libphonenumber-js'

    export default {
        props: ['regTrans', 'countriesCodes', 'show', 'defaultCode', 'emailCheckRoute', 'localization'],
        data() {
            return {
                email: null,
                emailValid: false,
                emailInvalid: false,
                emailMsg: null,
                emailXhr: false,
                mobile: null,
                country_code: null,
                country: '',
                number: '',
                phone_number: {
                    country: null,
                    number: null
                },

                phoneIsInInterFormat: null,
                localCountries: [],
                selectCode: '',
                countries: [],
            }
        },
        methods: {
            countrySelect() {
                this.$refs.input_mobile.focus()
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
            clickClose() {
                this.$emit('soft-registration-modal:cancel');
            },
            numberValidate() {
                if (this.phone_number.country && this.phone_number.number) {
                    let str = this.phone_number.country.dial_code + '' + this.phone_number.number;
                    if (isValidNumber(str, this.phone_number.country.code)) {
                        this.phoneIsInInterFormat = true;

                        this.mobile = parseNumber(str, this.phone_number.country.code);
                    } else {
                        this.phoneIsInInterFormat = false;
                        this.mobile = null;
                    }
                }

            },
            onSubmit() {
                // if (this.phoneIsInInterFormat && this.xhrEmailCheck(this.email)) {
                if (this.phoneIsInInterFormat && this.emailValid) {
                    this.$emit('soft-registration-modal:success', {email: this.email, mobile: this.phone_number.country.dial_code + this.phone_number.number});
                    $('#softRegistrationModal').modal('hide');
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
            show: function (val) {
                if (val) {
                    $('#softRegistrationModal').modal('show');
                    this.$emit('soft-registration-modal:show');
                }
            }
        },
        components: {
            Multiselect
        },
        created() {
            let self = this;
            $(function () {
                $('#softRegistrationModal').on('hide.bs.modal', function (e) {
                    self.$emit('soft-registration-modal:hide');
                })
            });

            for (let item in this.countriesCodes) {
                this.countries.push({
                    code: item,
                    dial_code: "+" + this.countriesCodes[item].code,
                    name: this.countryNameFormatter(this.countriesCodes[item].name)
                });
                // if (item == this.defaultCode) {
                //     this.phone_number.country = {
                //         code: item,
                //         dial_code: "+" + this.countriesCodes[item].code,
                //         name: this.countryNameFormatter(this.countriesCodes[item].name)
                //     }
                // }
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
</style>