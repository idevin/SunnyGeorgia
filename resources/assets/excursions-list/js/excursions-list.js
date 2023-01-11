import env from '../../../../.env.webpack'
import '../../common-styles/site-common.scss'
import '../../common-styles/breadcrumbs.scss'
import '../scss/excursions-list.scss'

import './bootstrap'
import Vue from 'vue';
import VueGtm from 'vue-gtm';
import BackToTop from 'vue-backtotop';
import HeaderNavigation from '../../shared-components/HeaderNavigation'
import { stringify, parse } from "qs";


const ExcursionsFilter = () => ({
    component: import('../js/components/ExcursionsFilter'),
});
const ExcursionsSearch = () => ({
    component: import('../js/components/ExcursionsSearch'),
});
const ExcursionsSort = () => ({
    component: import('../js/components/ExcursionsSort'),
});
const ExcursionsMobileSort = () => ({
    component: import('../js/components/ExcursionsMobileSort')
});
import ExcursionsList from "../js/components/ExcursionsList";

const AuthModal = () => ({
    component: import('../../shared-components/auth/AuthModal')
});

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
Vue.filter('choice', (...args) => {
    return lang.choice(...args);
});
Vue.filter('moneyFormatter', function (value) {
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
Vue.component('header-navigation', HeaderNavigation);
Vue.component('auth-modal', AuthModal);

Vue.component('excursions-list', ExcursionsList);
Vue.component('excursions-mobile-sort', ExcursionsMobileSort);
Vue.component('excursions-filter', ExcursionsFilter);
Vue.component('excursions-search', ExcursionsSearch);
Vue.component('excursions-sort', ExcursionsSort);

// Disable “development mode” warning in VueJS
Vue.config.productionTip = env.PROD !== 'true';
Vue.config.devtools = env.PROD !== 'true';

export const excursionsList = new Vue({
    el: '#app',
    store,
    data: () => ({
        modalTabName: '',
        filters: {
            search: {},
            sort: '',
            filter: {},
            page: null,
        },
        total: 0,
    }),
    computed: {
        modalTab () {
            return this.$store.state.authModal.tab
        },
    },
    methods: {
        filterChange(data, filterName) {
            this.filters[filterName] = data;
            this.changeUrl(filterName)
        },
        changeUrl(filterName){
            const data = {
                ...this.filters.search,
                ...this.filters.filter
            };
            if(this.filters.sort) {
                data.sort = this.filters.sort
            }
            if(this.filters.page > 1 && filterName === 'page') {
                data.page = this.filters.page
            }
            let params = stringify(data,{
                encode: false,
                arrayFormat: 'indices',
                addQueryPrefix: true
            });
            const url = window.location.href.split('?')[0] + params;
            window.history.pushState('','', url);
            this.$refs.excursionsList.getExcursions();
            this.$refs.excursionsFilter.getExcursionsParams();
        },
        gatParamsFromUrl() {
            let query = parse(window.location.search, {
                depth: 2,
                ignoreQueryPrefix: true
            });
            if(query) {
                if(query.place) {
                    this.filters.search.place = +query.place;
                    delete query.place
                }
                if(query.date) {
                    this.filters.search.date = query.date;
                    delete query.date
                }
                if(query.sort) {
                    this.filters.sort = query.sort;
                    delete query.sort
                }
                if(query.page) {
                    this.filters.page = +query.page;
                    delete query.page
                }
                this.filters.filter = query
            }
        }
    },
    created() {
        this.gatParamsFromUrl()
    },
    mounted() {
        if(window.Laravel.user) {
            window.Laravel.user.csrfToken = window.Laravel.csrfToken;
            this.$store.dispatch('receiveUser', window.Laravel.user);
        }
        window.addEventListener('popstate', () => {
            this.gatParamsFromUrl();
            this.$refs.excursionsList.getExcursions();
            this.$refs.excursionsFilter.getExcursionsParams();
        })
    }
});
