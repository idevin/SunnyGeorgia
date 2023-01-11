/**
 * Vendor JS code
 */
require('jquery/dist/jquery.js');
require('jquery-raty-js/lib/jquery.raty.js');
require('jquery.nicescroll/jquery.nicescroll.js');
require('jquery.resizeend/lib/jquery.resizeend.js');
require('bootstrap/js/dist/index.js');
require('daterangepicker/daterangepicker.js');
require('nouislider/distribute/nouislider.js');
require('select2/dist/js/select2.js');
require('lazysizes/lazysizes.js');
require('wnumb/wNumb.js');
require('wowjs/dist/wow.js');
require('wickedpicker/dist/wickedpicker.min.js');
require('hc-sticky/dist/hc-sticky.js');
require('is_js/is.min.js');
require('moment');
// require ('fotorama/fotorama.js');

/**
 * Vendor style load
 */
require('bootstrap/scss/bootstrap-grid.scss');
require('bootstrap/scss/bootstrap.scss');
require('bootstrap-datepicker/dist/css/bootstrap-datepicker3.css');
require('daterangepicker/daterangepicker.css');
require('animate.css/animate.css');
require('nouislider/distribute/nouislider.css');
require('v-calendar/lib/v-calendar.min.css');
require('jquery-raty-js/lib/jquery.raty.css');
require('wickedpicker/dist/wickedpicker.min.css');
require('select2/dist/css/select2.css');
// require ('fotorama/fotorama.css');
require('font-awesome/css/font-awesome.min.css');

/**
 * Custome style load
 */
require('../../common-styles/legacy.css');
require('../sass/bootstrap-custom.css');
require('../sass/select2-custom.css');
require('../sass/app.scss');
import '../../common-styles/site-common.scss'


/**
 * Custome Legacy JS code
 */
require('./bootstrap');
require('./legacy');


/**
 * Main App Vue instanse load
 */
import Vue from 'vue';
import * as _ from 'lodash';
import {store} from './store';
import {i18n} from './locales/Locale';

import VCalendar from 'v-calendar';
import SocialSharing from 'vue-social-sharing';
import VeeValidate from 'vee-validate';
import Toasted from 'vue-toasted';
import VueAwesomeSwiper from 'vue-awesome-swiper';

// Import components styles
import 'swiper/dist/css/swiper.css';

// Import custom components
import {PageTours} from './components/pages/PageTours';
import {GallerySwiper} from './components/GallerySwiper';
import AuthModal from '../../shared-components/auth/AuthModal'

// Disable “development mode” warning in VueJS
Vue.config.productionTip = false;

/**
 * Register vue plagins
 */

Vue.use(SocialSharing);
Vue.use(VeeValidate);
Vue.use(VCalendar, {
    firstDayOfWeek: 2,
    locale: 'ru'
});
Vue.use(Toasted, {
    containerClass: 'notification',
    className: 'notification__item',
    position: 'top-right',
    duration: 4000,
    action: [
        {
            text: 'Close',
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        },
    ]
});
Vue.use(VueAwesomeSwiper, /* { default global options } */);

/**
 * Register Vue Filters
 */

Vue.filter('moneyFormatterFilter', function (value) {
    value = parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ");
    let splited = value.split('.');
    if(splited[1] === '00'){
        value = splited[0];
    }
    return value;
});

/**
 * Register vue components
 */

Vue.component('back-to-top', require('./components/BackToTop.vue').default);
Vue.component('excursion-order', require('./components/ExcursionOrder.vue').default);
Vue.component('tour-order', require('./components/TourOrder.vue').default);

// Shared
Vue.component('shared-loader', require('./components/shared/SharedLoader.vue').default);
Vue.component('shared-weather', require('./components/shared/SharedWeather.vue').default);
Vue.component('shared-map', require('./components/shared/SharedMap.vue').default);
Vue.component('contact-map', require('./components/shared/ContactMap.vue').default);

// User
Vue.component('user-registration-steps', require('./components/UserRegistrationSteps.vue').default);
Vue.component('user-registration',       require('./components/UserSoftRegistration.vue').default);
Vue.component('user-soft-registration', require('./components/UserSoftRegistrationModal.vue').default);
Vue.component('user-login',              require('./components/UserLogin.vue').default);
Vue.component('tel-input',               require('./components/TelInput.vue').default);

Vue.component('header-navigation', require('../../shared-components/HeaderNavigation.vue').default);
Vue.component('clouds-decor', require('../../shared-components/CloudsDecor.vue').default);

Vue.component('accommodations-calendar', require('./components/AccommodationsCalendar.vue').default);
Vue.component('accommodations-person-counter', require('./components/AccommodationsPersonCounter.vue').default);
Vue.component('accommodations-food-counter', require('./components/AccommodationsFoodCounter.vue').default);
Vue.component('accommodations-transfer-counter', require('./components/AccommodationsTransferCounter.vue').default);
Vue.component('accommodations-details', require('./components/AccommodationsDetails.vue').default);
Vue.component('accommodations-rooms-count', require('./components/AccommodationsRoomsCount.vue').default);
Vue.component('accommodations-adults-scorer', require('./components/AccommodationsAdultsScorer.vue').default);
Vue.component('accommodations-kids-scorer', require('./components/AccommodationsKidsScorer.vue').default);
Vue.component('accommodations-beds-scorer', require('./components/AccommodationsBedsScorer.vue').default);
Vue.component('accommodations-notes', require('./components/AccommodationsNotes.vue').default);
Vue.component('accommodations-submit', require('./components/AccommodationsSubmit.vue').default);

// Filter & list components
Vue.component('list-tours', require('./components/lists/ListTours.vue').default);
Vue.component('list-excursions', require('./components/lists/ListExcursions.vue').default);
Vue.component('filter-tours', require('./components/filter/FilterTours.vue').default);
Vue.component('filter-excursions', require('./components/filter/FilterExcursions.vue').default);
// ======
Vue.component('page-tours', PageTours);

Vue.component('gallery-swiper', GallerySwiper);

import Lang from 'lang.js'
// добавить в messages файл перевода нужного модуля из php
import messages from '../translations/messages'

let locale = window.Laravel.locale || 'ru';

const lang = new Lang({
    messages: messages,
    locale: locale,
    fallback: 'ru'
});

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});

// @TODO
export const EventBus = new Vue();

// @ts-ignore: Unreachable code error
export const app = new Vue({
    el: '#app',
    components: {AuthModal},
    store: store,
    i18n: i18n,
    data: {
        modalTabName: '',
        user: {},
        softRegistrationModal: false,
        softRegistration: {email: null, mobile: null},
        loginModal: false,
        registrationModal: false,
    },
    methods: {
        onSoftRegOrder: function () {
            this.softRegistrationOrder = true;
        },
        onSoftRegSuccess: function (val) {
            let that = this;

            setTimeout(function () {
                if (that.softRegistrationOrder) {
                    $('#user-modal').modal('hide');
                    that.softRegistrationOrder = false;
                    that.softRegistration = val;
                    that.$refs.orderComponent.onBookingSubmit();

                } else {
                    document.location.reload(true);
                }
            }, 3000);

        },
        onSoftRegCancel: function () {
            this.$refs.orderComponent.stopOrdering();

        },
        onSoftRegHide: function () {
            this.softRegistrationOrder = false;

        },
        onSoftRegModalSuccess: function (val) {
            this.softRegistrationModal = false;
            this.softRegistration = val;
            this.$refs.orderComponent.onBookingSubmit();

        },
        onSoftRegModalCancel: function () {
            this.$refs.orderComponent.stopOrdering();
        },
        onSoftRegModalHide: function () {
            this.softRegistrationModal = false;
        }
    },
    mounted() {
        // Loading...
        this.$store.dispatch('receiveLoading', true);

        this.$nextTick(() => {
            // Check for Laravel errors & messages
            if (window.Laravel) {
                if (window.Laravel.status && window.Laravel.msg) {
                    this.$toasted.show(window.Laravel.msg, {
                        type: 'success'
                    });
                }
                if (window.Laravel.errors) {
                    for (let i in window.Laravel.errors) {
                        this.$toasted.show(window.Laravel.errors[i], {
                            type: 'error'
                        });
                    }
                }
            }
            if(window.Laravel.user) {
                window.Laravel.user.csrfToken = window.Laravel.csrfToken;
                this.$store.dispatch('receiveUser', window.Laravel.user);
            }
            this.$store.dispatch('receiveCurrency', window.Laravel.currency_code);
            this.$store.dispatch('receiveAccommodations', window.accommodations);

            // transfer
            this.$store.dispatch('receiveTransferIncluded', window.transfer_included);
            this.$store.dispatch('receiveTransferPrice', window.transfer_price);
            this.$store.dispatch('receiveTransferAvailability');

            // feeding
            this.$store.dispatch('receiveOptionsList', window.foodOptions);
            this.$store.dispatch('receiveFeedingAvailability');
            this.$store.dispatch('receiveFreeFeedingExist');
            this.$store.dispatch('receiveFeedingDefaultSelectedId');

            // tour
            this.$store.dispatch('receiveTourInfo', window.tour);
            this.$store.dispatch('receiveTourId', window.tour_id);
            this.$store.dispatch('receiveTourDays', window.tour_days);
            this.$store.dispatch('receiveTourNights', window.tour_nights);
            this.$store.dispatch('receiveTourTotalPrice');

            // Loading...
            this.$store.dispatch('receiveLoading', false);

        });
    },
    computed: {
        modalTab () {
            return this.$store.state.authModal.tab
        },
        storeMessages() {
            return this.$store.state.notifications.messages
        }
    },
    watch: {
        storeMessages(messages) {
            if(messages && messages.length){
                let message = messages.pop();
                this.$toasted.show(message.message, {
                    type: message.type
                });
                this.$store.commit('popMessage');
            }
        }
    },
});
