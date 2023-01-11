import * as types from './mutation-types'

const state = {
    config: {
        price: null,
        availability: null,
        included: null,
        checked: null
    }
}

const mutations = {
    [types.RECEIVE_TRANSFER_PRICE] (state, payload) {
        state.config.price = payload
    },

    [types.RECEIVE_TRANSFER_AVAILABILITY] (state, payload) {
        state.config.availability = payload
    },

    [types.RECEIVE_TRANSFER_INCLUDED] (state, payload) {
        state.config.included = payload
    },

    [types.RECEIVE_TRANSFER_CHECKED] (state, payload) {
        state.config.checked = payload
    }
}

const actions = {
    receiveTransferPrice ({ state, commit }, payload) {
        commit(types.RECEIVE_TRANSFER_PRICE, Number.parseInt(payload))
    },

    // если с бека пришла стоимость трансфера === null,
    // это означает что трансфер недоступен
    receiveTransferAvailability ({ state, commit, getters }) {
        if (getters.transferPrice === null) {
            commit(types.RECEIVE_TRANSFER_AVAILABILITY, false)
        } else {
            commit(types.RECEIVE_TRANSFER_AVAILABILITY, true)
        }
    },

    receiveTransferIncluded ({ state, commit }, payload) {
        commit(types.RECEIVE_TRANSFER_INCLUDED, payload)
    },

    setTransferChecked ({ state, commit }, payload) {
        commit(types.RECEIVE_TRANSFER_CHECKED, payload)
    }
}

const getters = {
    transferPrice (state) {
        return state.config.price
    },

    transferAvailability (state) {
        return state.config.availability
    },

    transferIncluded (state) {
        return state.config.included
    },

    transferChecked (state) {
        return state.config.checked
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}