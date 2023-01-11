import * as types from './mutation-types'

const state = {
    email: null,
    mobile: null
};

const mutations = {
    [types.SET_EMAIL](state, payload) {
        state.email = payload
    },
    [types.SET_MOBILE](state, payload) {
        state.mobile = payload
    },
};

const actions = {
    setInBooking({state, commit, rootState}, payload) {
        commit(types.RECEIVE_PLACE, payload)
    }
};

const getters = {
    registration(state, getters, rootState) {
        return state
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}