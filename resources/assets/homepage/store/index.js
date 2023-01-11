import Vue  from 'vue'
import Vuex from 'vuex'

import user           from './modules/user'
import notifications  from './modules/notifications'
import authModal      from './modules/auth-modal'
import tour           from './modules/tour'
import excursion           from './modules/excursion'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        user,
        notifications,
        authModal,
        tour,
        excursion
    }
});
