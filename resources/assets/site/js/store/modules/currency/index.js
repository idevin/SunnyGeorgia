import * as types from './mutation-types'

// некоторые значения из тех что должны прийти с бека - объявлены по умолчанию
// для реактивного связывания данных с компонентами их использующими
const state = {
    config: {
        code: null
    }
}

const mutations = {
    [types.RECEIVE_CURRENCY] (state, payload) {
        state.config.code = payload
    }
}

const actions = {
    receiveCurrency ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_CURRENCY, payload)
    }
}

const getters = {
    currency (state, getters, rootState) {
        return state.config
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}