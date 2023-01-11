import * as types from './mutation-types'

const state = {
    languages: null,
    defaultLanguage: null
}

const mutations = {
    [types.RECEIVE_LANGUAGES](state, payload) {
        state.languages = payload
    },

    [types.RECEIVE_DEFAULT_LANGUAGE](state, payload) {
        state.defaultLanguage = payload
    }
}

const actions = {
    receiveLanguages({state, commit}, payload) {
        commit(types.RECEIVE_LANGUAGES, payload)
    },

    receiveDefaultLanguage({state, commit}, payload) {
        commit(types.RECEIVE_DEFAULT_LANGUAGE, payload)
    }
}

const getters = {
    languages (state) {
        return state.languages
    },

    defaultLanguage (state) {
        return state.defaultLanguage
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}