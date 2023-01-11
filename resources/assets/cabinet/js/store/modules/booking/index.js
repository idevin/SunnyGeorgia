import * as types from './mutation-types'

const state = {
    booking: {
        confirmed: false,
        user: {
            mobile_confirmed: false,
            email_verified: false
        }
    }
}

const mutations = {
    [types.RECEIVE_BOOKING](state, payload) {
        state.booking = payload
    },

    [types.RECEIVE_BOOKING_CONFIRMED](state, payload) {
        state.booking.confirmed = payload
    }
}

const actions = {
    receiveBooking({state, commit}, payload) {
        commit(types.RECEIVE_BOOKING, payload)
    },

    receiveBookingConfirmed({state, commit}, payload) {
        commit(types.RECEIVE_BOOKING_CONFIRMED, payload)
    }
}

const getters = {
    booking (state) {
        return state.booking
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}