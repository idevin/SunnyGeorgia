import env from '../../../../.env.webpack'
import '../../common-styles/site-common.scss'
import '../../common-styles/breadcrumbs.scss'
import '../scss/excursion.scss'

import './bootstrap'
import Vue from 'vue';
import VueGtm from 'vue-gtm';
// import Toasted from 'vue-toasted';
import BackToTop from 'vue-backtotop';
import HeaderNavigation from '../../shared-components/HeaderNavigation'
import VueObserveVisibility from 'vue-observe-visibility'
import SharedLoader from '../../shared-components/SharedLoader'

const SharedSocialSharing = () => ({
    component: import('../../shared-components/SharedSocialSharing'),
});
const SharedWeather = () => ({
    component: import('../../shared-components/SharedWeather'),
});

const ExcursionOrder = () => ({
    component: import('./components/ExcursionOrder'),
    loading: SharedLoader,
});
const AuthModal = () => ({
    component: import('../../shared-components/auth/AuthModal')
});
import PriceIncludeExclude from './components/PriceIncludeExclude';
import ProductGallery from '../../shared-components/ProductGalleryNew';

import 'lazysizes'
import {store} from '../store';
import Lang from 'lang.js'
// добавить в messages файл перевода нужного модуля из php
import messages from '../translations/messages'
let locale =  window.Laravel.locale || 'ru';

const lang = new Lang({
    messages: messages,
    locale: locale,
    fallback: 'ru'
});

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});
Vue.filter('moneyFormatterFilter', function (value) {
    value = parseFloat(value).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ");
    let splited = value.split('.');
    if(splited[1] === '00'){
        value = splited[0];
    }
    return value;
});
const SideBar = () => ({
    component: import('../../shared-components/SideBar')
});
Vue.use(VueGtm, {
    id: env.GOOGLE_GTM, // Your GTM ID
    enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
    debug: true, // Whether or not display console logs debugs (optional)
});
Vue.use(BackToTop);
Vue.use(VueObserveVisibility);
Vue.component('shared-loader', SharedLoader);
Vue.component('shared-social-sharing', SharedSocialSharing);
Vue.component('shared-weather', SharedWeather);
Vue.component('product-gallery', ProductGallery);
Vue.component('header-navigation', HeaderNavigation);
Vue.component('auth-modal', AuthModal);
Vue.component('excursion-order', ExcursionOrder);
Vue.component('price-include-exclude', PriceIncludeExclude);
Vue.component('side-bar', SideBar);

// Disable “development mode” warning in VueJS
Vue.config.productionTip = env.PROD !== 'true';
Vue.config.devtools = env.PROD !== 'true';

export const excursion = new Vue({
    el: '#app',
    store: store,
    data() {
        return {
            modalTabName: '',
            showPrepayment: true,
            showDescription: true,
            showFullDescription: true,
            domLoaded: false,
            orderVisible: false
        }
    },
    computed: {
        modalTab () {
            return this.$store.state.authModal.tab
        },
    },
    methods: {
        visibilityChanged (isVisible, entry) {
            this.orderVisible = isVisible
        }
    },
    mounted() {
        if(window.Laravel.user) {
            window.Laravel.user.csrfToken = window.Laravel.csrfToken;
            this.$store.dispatch('receiveUser', window.Laravel.user);
        }
        document.addEventListener("DOMContentLoaded", () => {
            this.domLoaded = true;
        })
    }
});
