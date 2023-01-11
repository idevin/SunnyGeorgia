import * as types from './mutation-types'

const state = {
    place: {}
}

const mutations = {
    [types.RECEIVE_PLACE] (state, payload) {
        state.place = payload
    }
}

const actions = {
    receivePlace ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_PLACE, payload)
    }
}

const getters = {
    place (state, getters, rootState) {
        return state.place
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}