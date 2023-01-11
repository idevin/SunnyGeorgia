import * as types from './mutation-types'

const state = {
    config: {
        loading: null
    }
}

const mutations = {
    [types.RECEIVE_LOADING] (state, payload) {
        state.config.loading = payload
    }
}

const actions = {
    receiveLoading ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_LOADING, payload)
    }
}

const getters = {
    loading (state, getters, rootState) {
        return state.config.loading
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}