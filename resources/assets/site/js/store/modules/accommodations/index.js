import * as types from './mutation-types'

const state = {
    all: null
}

const mutations = {
    // записать список ВСЕХ размещений, доступных в рамках ТЕКУЩЕГО тура
    [types.RECEIVE_ACCOMMODATIONS] (state, payload) {
        state.all = payload
    }
}

const actions = {
    // получить список ВСЕХ размещений, доступных в рамках ТЕКУЩЕГО тура
    receiveAccommodations ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_ACCOMMODATIONS, payload)
    }
}

const getters = {
    // вернуть список ВСЕХ размещений, доступных в рамках ТЕКУЩЕГО тура
    accommodations (state, getters, rootState) {
        return state.all
    },

    // вернуть КОНКРЕТНОЕ размещение по его ID, из доступных в рамках ТЕКУЩЕГО тура
    singleAccommodation (state, getters, rootState) {
        return (id) => {
            return state.all[id]
        }
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}