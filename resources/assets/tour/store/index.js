import Vue  from 'vue'
import Vuex from 'vuex'

import user           from '../../store/modules/user'
import notifications  from '../../store/modules/notifications'
import authModal      from '../../store/modules/auth-modal'
import calendar      from '../../store/modules/calendar'
import tour      from '../../store/modules/tour'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        user,
        notifications,
        authModal,
        calendar,
        tour
    }
});
