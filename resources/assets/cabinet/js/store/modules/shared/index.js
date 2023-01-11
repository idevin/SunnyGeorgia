import * as types from './mutation-types'

const state = {
    config: {
        loading: false,
        composerCurrencies: null
    }
}

const mutations = {
    [types.RECEIVE_LOADING] (state, payload) {
        state.config.loading = payload
    },

    [types.RECEIVE_COMPOSER_CURRENCIES] (state, payload) {
        state.config.composerCurrencies = payload
    }
}

const actions = {
    receiveLoading ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_LOADING, payload)
    },

    receiveComposerCurrencies ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_COMPOSER_CURRENCIES, payload)
    }
}

const getters = {
    loading (state, getters, rootState) {
        return state.config.loading
    },

    composerCurrencies (state, getters, rootState) {
        return state.config.composerCurrencies
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}