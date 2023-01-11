<template>
    <div class="modal-bg" id="auth-modal" @click="closeModal">
        <div class="modal-body">
            <div v-if="componentName !== 'request-accepted'" class="switcher">
                <span v-if="componentName === 'confirm-phone'"
                      class="switcher-item width100"
                >{{'auth.mobile number confirmation' | trans}}</span>
                <span v-if="componentName === 'remember-pass'"
                      class="switcher-item width100"
                >{{'auth.restore password' | trans}}</span>
                <span v-if="componentName === 'login' || componentName === 'registration'"
                      @click="componentName = 'login'"
                      class="switcher-item"
                      :class="{active: componentName === 'login'}"
                >{{'auth.login' | trans}}</span>
                <span v-if="componentName === 'login' || componentName === 'registration'"
                      @click="componentName = 'registration'"
                      class="switcher-item"
                      :class="{active: componentName === 'registration'}"
                >{{'auth.registration' | trans}}</span>
            </div>
            <div class="modal-content">
                <transition name="fade" mode="out-in">
                    <transition name="fade" mode="out-in">
                        <user-registration
                                v-if="componentName === 'registration'"
                                :route="registerRoute"
                                :terms="termsRoute"
                                @user-registered="userRegistered"
                        ></user-registration>
                        <user-register-accepted
                                v-if="componentName === 'user-register-accepted'"
                                :message="serverMessage"
                        ></user-register-accepted>

                        <user-login
                                v-if="componentName === 'login'"
                                @remember-pass="componentName = 'remember-pass'"
                                :route="loginRoute"
                        ></user-login>

                        <user-register-and-product-accepted
                                v-if="componentName === 'user-register-and-product-accepted'"
                        ></user-register-and-product-accepted>
                        <product-accepted
                                v-if="componentName === 'product-accepted'"
                        ></product-accepted>

                        <confirm-phone
                                v-if="componentName === 'confirm-phone'"
                                :emitter="confirmPhoneEmitter"
                        ></confirm-phone>

                        <user-remember-pass
                                v-if="componentName === 'remember-pass'"
                                :route="forgotPasswordRoute"
                        ></user-remember-pass>
                    </transition>
                </transition>
            </div>
        </div>
    </div>
</template>
<script>
    import UserLogin from "./UserLogin";
    import UserRegistration from "./UserRegistration";
    import UserRememberPass from "./UserRememberPass";
    import ConfirmPhone from "./ConfirmPhone";
    import UserRegisterAccepted from "./UserRegisterAccepted";
    import UserRegisterAndProductAccepted from "./UserRegisterAndProductAccepted";
    import ProductAccepted from "./ProductAccepted";

    export default {
        components: {
            UserRegistration,
            UserRegisterAccepted,
            UserLogin,
            UserRegisterAndProductAccepted,
            ProductAccepted,
            ConfirmPhone,
            UserRememberPass
        },
        props: {
            'register-route': {
                type: String,
                default: 'register'
            },
            'login-route': {
                type: String,
                default: 'login'
            },
            'terms-route': {
                type: String,
                default: 'ru/terms'
            },
            'forgot-password-route': {
                type: String,
                default: 'ru/password/email'
            },
        },
        data() {
            return {
                componentName: 'login',
                confirmPhoneEmitter: 'login',
                serverMessage: null
            }
        },
        methods: {
            closeModal(e) {
                if (e.target.id === 'auth-modal') {
                    if (this.tourInProcess) {
                        this.$store.commit('setTourInProcess', false);
                    } else if (this.excursionInProcess) {
                        this.$store.commit('setExcursionInProcess', false);
                    }
                    this.$store.commit('authModalTab', '')
                }
            },
            userRegistered(message) {
                if (this.tourInProcess || this.excursionInProcess) {
                    this.$gtm.trackEvent({
                        event: 'GAEvent',
                        category: 'Booking ' + this.productType,
                        action: 'registration_success',
                        label: this.user.email,
                    });
                    this.confirmPhoneEmitter = 'registration';
                    this.$store.commit('authModalTab', 'confirm-phone')
                } else {
                    this.serverMessage = message;
                    this.$store.commit('authModalTab', 'user-register-accepted')
                }
            }
        },
        computed: {
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
            tab() {
                return this.$store.state.authModal.tab
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
        watch: {
            tab: {
                handler(val) {
                    this.componentName = val;
                },
                immediate: true
            }
        }
    }
</script>

<style scoped>
    .modal-bg {
        position: fixed;
        background-color: rgba(0, 0, 0, .5);
        z-index: 1000;
        display: flex;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        overflow: scroll;
    }

    .modal-body {
        margin: auto 15px;
        background-color: white;
        color: black;
        border-radius: 6px;
        padding: 0;
        box-shadow: 0 0 10px rgba(0, 0, 0, .3);
        width: 100%;
        max-width: 560px;
        max-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .switcher {
        background: #ebeef3;
        display: flex;
        border-radius: 6px 6px 0 0;
    }

    .switcher-item {
        display: block;
        width: 50%;
        text-transform: uppercase;
        cursor: pointer;
        padding: 10px 20px;
        text-align: center;
        font-size: 15px;
        transition: background ease .3s;
    }

    .switcher-item.width100 {
        cursor: default;
        width: 100%;
        text-align: center;
    }

    .switcher-item.width100:hover {
        background: transparent;
    }

    .switcher-item.active {
        background: #fff;
    }

    .switcher-item:hover {
        background: #fff;
    }

    .switcher-item:first-child {
        border-top-left-radius: 6px;
    }

    .switcher-item:last-child {
        border-top-right-radius: 6px;
    }

    .modal-content {
        padding: 20px 15px 40px 15px;
        height: 100%;
        overflow: auto
    }

    @media (min-width: 576px) {

        .modal-content {
            padding: 20px 100px 40px 100px;
        }

        .modal-body {
            margin: auto;
        }
    }
</style>
