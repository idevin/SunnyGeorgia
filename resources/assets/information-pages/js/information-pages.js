import env from '../../../../.env.webpack'
import '../../common-styles/site-common.scss'
import '../../common-styles/breadcrumbs.scss'
import '../../common-styles/legacy.css'
import '../scss/information-pages.scss'

import './bootstrap'
import Vue from 'vue';
import 'lazysizes'
import BackToTop from 'vue-backtotop';
import HeaderNavigation from '../../shared-components/HeaderNavigation'
import {store} from '../store';
Vue.use(BackToTop);
Vue.component('header-navigation', HeaderNavigation);

Vue.component('auth-modal', () => ({
    component: import('../../shared-components/auth/AuthModal')
}));

Vue.component('legal-information', () => ({
    component: import('./components/legalInformation')
}));

Vue.component('contacts-page', () => ({
    component: import('./components/ContactsPage')
}));

Vue.component('google-map', () => ({
    component: import('./components/GoogleMap')
}));

// Disable “development mode” warning in VueJS
Vue.config.productionTip = env.PROD !== 'true';
Vue.config.devtools = env.PROD !== 'true';

export const informationPages = new Vue({
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
