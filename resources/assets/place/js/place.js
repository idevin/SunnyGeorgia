import env from '../../../../.env.webpack'
import '../../common-styles/site-common.scss'
import '../../common-styles/breadcrumbs.scss'
import '../scss/place.scss'

import './bootstrap'
import Vue from 'vue';
import VueGtm from 'vue-gtm';
import BackToTop from 'vue-backtotop';
import HeaderNavigation from '../../shared-components/HeaderNavigation'
import VueObserveVisibility from 'vue-observe-visibility'
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

Vue.use(VueGtm, {
    id: env.GOOGLE_GTM, // Your GTM ID
    enabled: true, // defaults to true. Plugin can be disabled by setting this to false for Ex: enabled: !!GDPR_Cookie (optional)
    debug: true, // Whether or not display console logs debugs (optional)
});
Vue.use(BackToTop);
Vue.use(VueObserveVisibility);
Vue.component('header-navigation', HeaderNavigation);


Vue.component('place-navigation', () => ({
    component: import('./components/Navigation')
}));
Vue.component('cms-content', () => ({
    component: import('./components/CmsContent')
}));
Vue.component('shared-social-sharing', () => ({
    component: import('../../shared-components/SharedSocialSharing'),
}));
Vue.component('shared-weather', () => ({
    component: import('../../shared-components/SharedWeather'),
}));
Vue.component('auth-modal', () => ({
    component: import('../../shared-components/auth/AuthModal')
}));
Vue.component('side-bar', () => ({
    component: import('../../shared-components/SideBar')
}));

// Disable “development mode” warning in VueJS
Vue.config.productionTip = env.PROD !== 'true';
Vue.config.devtools = env.PROD !== 'true';

export const place = new Vue({
    el: '#app',
    store: store,
    data() {
        return {
            modalTabName: '',
        }
    },
    computed: {
        modalTab () {
            return this.$store.state.authModal.tab
        },
    },
    methods: {
    },
    mounted() {
        if(window.Laravel.user) {
            window.Laravel.user.csrfToken = window.Laravel.csrfToken;
            this.$store.dispatch('receiveUser', window.Laravel.user);
        }
    }
});
