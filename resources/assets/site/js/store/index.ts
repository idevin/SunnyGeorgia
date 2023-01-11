import Vue  from 'vue'
import Vuex from 'vuex'

import shared         from './modules/shared'
import place          from './modules/place'
import user           from './modules/user'
import notifications  from './modules/notifications'
import accommodations from './modules/accommodations'
import currency       from './modules/currency'
import calendar       from './modules/calendar'
import transfer       from './modules/transfer'
import feeding        from './modules/feeding'
import tour           from './modules/tour'
import excursion      from './modules/excursion'
import authModal      from './modules/auth-modal'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        shared,
        place,
        user,
        notifications,
        accommodations,
        currency,
        calendar,
        transfer,
        feeding,
        tour,
        excursion,
        authModal
    }
});
