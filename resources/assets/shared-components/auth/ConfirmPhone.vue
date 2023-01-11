<template>
  <div>
    <div class="form-group text-center">
      <p>{{ 'auth.mobile number verification required' | trans }}<br>
        {{ 'auth.please enter your number' | trans }}
      </p>
    </div>
    <div class="form-group">
      <form ref="phone" class="form-input">
        <input type="tel"
               autocomplete="tel"
               required
               placeholder="+995 11 222 33 44"
               v-model="mobile_number"
               v-mask="phoneMask"
        >
        <div class="validation-error-text" v-if="phoneError">
          {{ phoneError }}
        </div>
      </form>
    </div>
    <div class="form-group text-right">
      <shared-loader v-if="phoneSending"></shared-loader>
      <button v-else
              class="register-btn"
              :class="{disabled: sending}"
              @click="send"
      >{{ 'auth.send' | trans }}
      </button>
    </div>
    <template v-if="codeSend">
      <div class="form-group text-center">
        <p>{{ 'auth.code sent' | trans }}</p>
      </div>
      <div class="form-group text-center">
        <span @click="resend" class="link">{{ 'auth.try again' | trans }}</span>
      </div>
      <div class="form-group text-center">
        <p>{{ 'auth.enter code' | trans }}</p>
      </div>
      <div class="form-group">
        <form ref="code" class="form-input">
          <input type="text"
                 placeholder="1234"
                 v-model="smsCode"
                 required
                 minlength="3"
                 maxlength="5"
          >
        </form>
      </div>
      <div class="form-group" v-if="serverError">
        <div class="validation-error-text">
          {{ serverError }}
        </div>
      </div>
      <div class="form-group text-right">
        <shared-loader v-if="codeSending"></shared-loader>
        <button v-else
                class="register-btn"
                :class="{disabled: !codeSend}"
                @click="check"
        >{{ 'auth.confirm' | trans }}
        </button>
      </div>
    </template>
  </div>
</template>

<script>
import { VueMaskDirective } from 'v-mask'
import { AsYouType } from 'libphonenumber-js/mobile'

export default {
  directives: {
    mask: VueMaskDirective
  },
  props: {
    emitter: String
  },
  data() {
    return {
      mobile_number: '',
      mobile_confirmed: false,
      smsCode: '',
      sending: false,
      phoneSending: false,
      codeSending: false,
      codeSend: false,
      successful: false,
      serverError: '',
      phoneError: '',
      phoneMask: '+### ## ### ## ##',
      formatPhone: ''
    }
  },
  methods: {
    send() {
      this.sendPhone('confirm-send')
    },
    resend() {
      this.sendPhone('confirm-resend')
    },
    sendPhone(route) {
      if (!this.sending && !this.phoneSending) {
        if (this.$refs.phone.reportValidity()) {
          this.sending = true;
          this.phoneSending = true;
          this.phoneError = '';
          //todo привязать роут динамически
          axios.get(`/ru/sms/${route}`, {
            params: {mobile_phone: this.mobile_number.replace(/ /g, '')}
          })
              .then(resp => {
                if (this.tourInProcess || this.excursionInProcess) {
                  this.$gtm.trackEvent({
                    event: 'GAEvent',
                    category: 'Booking ' + this.productType,
                    action: 'user_send_phone',
                    label: this.user.email + ' ' + this.mobile_number,
                  });
                }
                if (route === 'confirm-send') {
                  this.$store.dispatch('receiveUser', resp.data.user);
                }
                this.codeSend = true;
              })
              .catch(error => {
                if (error.response.status === 400) {
                  this.phoneError = error.response.data;
                } else if (error.response.status === 422) {
                  if (error.response.data.errors.mobile_phone) {
                    this.phoneError = this.$options.filters.trans('auth.wrong mobile phone format');
                  }
                } else {
                  this.phoneError = error.response.data;
                }
                this.codeSend = false;
              })
              .finally(() => {
                this.sending = false;
                this.phoneSending = false;
              });
        }
      }
    },
    check() {
      if (this.codeSend && !this.sending && !this.codeSending) {
        if (this.$refs.code.reportValidity()) {
          this.sending = true;
          this.codeSending = true;
          let tabName = this.emitter === 'registration' ?
              'user-register-and-product-accepted' : 'product-accepted';
          //todo привязать роут динамически
          axios.get(`/${window.Laravel.locale}/sms/confirm-check`, {params: {code: this.smsCode}})
              .then(resp => {
                this.$store.commit('setUserMobileConfirmed', true);
                if (this.tourInProcess || this.excursionInProcess) {
                  let action = this.tourInProcess ? 'sendTourOrder' : 'sendExcursionOrder';
                  this.$gtm.trackEvent({
                    event: 'GAEvent',
                    category: 'Booking ' + this.productType,
                    action: 'confirm_phone_success',
                    label: this.user.email,
                  });
                  this.$store.dispatch(action).then(() => {
                    this.$store.commit('authModalTab', tabName);
                    this.$gtm.trackEvent({
                      event: 'GAEvent',
                      category: 'Booking ' + this.productType,
                      action: 'finish',
                    });
                  });
                }
              })
              .catch(error => {
                this.serverError = 'не верный sms код';
                this.sending = false;
                this.codeSending = false;
              })
        }
      }
    }
  },
  computed: {
    user() {
      return this.$store.getters.user
    },
    excursionInProcess() {
      if (this.$store.state.excursion) {
        return this.$store.state.excursion.excursionInProcess
      }
    },
    tourInProcess() {
      if (this.$store.state.tour) {
        return this.$store.state.tour.tourInProcess
      }
    },
    productType() {
      if (this.tourInProcess || this.excursionInProcess) {
        return this.tourInProcess ? 'tour' : 'excursion';
      }
    }
  },
  watch: {
    'user.mobile_number': {
      handler(mobile_number) {
        if (mobile_number) {
          this.mobile_number = mobile_number
        }
      },
      immediate: true
    },
    mobile_number(val) {
      if (val) {
        const asYouType = new AsYouType();
        let number = asYouType.input(val);
        if (asYouType.getNumber() && asYouType.getNumber().country) {
          this.phoneMask = number.replace(/[0-9]/g, '#')
        }
      }
    }
  },
}
</script>

<style scoped>
.form-group {
  margin-bottom: 20px;
  font-size: 16px
}

.text-center.form-group {
  margin-bottom: 10px
}

.text-center.form-group p {
  margin: 0;
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

.text-center.form-group {
  font-size: 14px;
  color: #666
}
</style>
