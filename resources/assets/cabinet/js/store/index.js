import Vue  from 'vue'
import Vuex from 'vuex'

import languages from './modules/languages'
import tour      from './modules/tour'
import excursion from './modules/excursion'
import booking   from './modules/booking'
import shared    from './modules/shared'

Vue.use(Vuex)

export const store = new Vuex.Store({
    modules: {
        shared,
        languages,
        tour,
        excursion,
        booking
    }
});