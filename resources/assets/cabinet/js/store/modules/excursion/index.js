import * as types from './mutation-types'

const state = {
    excursion: undefined
}

const mutations = {
    [types.SET_EXCURSION](state, payload) {
        state.excursion = payload
    }
}

const actions = {
    setLoadedExcursion({state, commit}, payload) {
        commit(types.SET_EXCURSION, payload)
    }
}

const getters = {
    excursion (state) {
        return state.tour
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
