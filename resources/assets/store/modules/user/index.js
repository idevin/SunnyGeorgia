import * as types from './mutation-types'

const state = {
    config: null,
};

const mutations = {
    [types.RECEIVE_USER] (state, payload) {
        state.config = payload
    },
    setUserMobileConfirmed(state, payload) {
        state.config.mobile_confirmed = payload
    }
};

const actions = {
    receiveUser ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_USER, payload);
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = payload.csrfToken
    }
};

const getters = {
    user (state, getters, rootState) {
        return state.config
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}
