import '../../common-styles/site-common.scss'
import '../scss/homepage.scss';

import './bootstrap'
import Vue from 'vue';
import VCalendar from 'v-calendar';
import 'v-calendar/lib/v-calendar.min.css';
import Toasted from 'vue-toasted';
import BackToTop from 'vue-backtotop';
import SearchForm from './components/SearchForm'
import HeaderNavigation from '../../shared-components/HeaderNavigation'
import CloudsDecor from '../../shared-components/CloudsDecor'
import AuthModal from '../../shared-components/auth/AuthModal'

import 'lazysizes'
import Lang from 'lang.js'
// добавить в messages файл перевода нужного модуля из php
import messages from '../translations/messages'
let locale =  window.Laravel.locale || 'ru';
import {store} from '../store';

const lang = new Lang({
    messages: messages,
    locale: locale,
    fallback: 'ru'
});

Vue.filter('trans', (...args) => {
    return lang.get(...args);
});

Vue.use(VCalendar, {
    firstDayOfWeek: 2,
    locale: window.Laravel.locale
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
Vue.use(BackToTop);
// Disable “development mode” warning in VueJS
Vue.config.productionTip = true;
Vue.config.devtools = true;

export const homepage = new Vue({
    el: '#app',
    store: store,
    components: {SearchForm, HeaderNavigation, AuthModal, CloudsDecor},
    data() {
        return {
            modalTabName: '',
        }
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
    mounted() {
        if(window.Laravel.user) {
            window.Laravel.user.csrfToken = window.Laravel.csrfToken;
            this.$store.dispatch('receiveUser', window.Laravel.user);
        }
    }
});
