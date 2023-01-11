import Vue  from 'vue'
import Vuex from 'vuex'

import user           from '../../store/modules/user'
import notifications  from '../../store/modules/notifications'
import authModal      from '../../store/modules/auth-modal'
import excursion      from '../../store/modules/excursion'
import calendar      from '../../store/modules/calendar'

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        user,
        notifications,
        authModal,
        excursion,
        calendar
    }
});
