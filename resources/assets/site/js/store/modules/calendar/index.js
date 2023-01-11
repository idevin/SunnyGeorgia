import * as types from './mutation-types'

const state = {
    config: {
        currentDate: null,
        tomorrowDate: null,
        availableDates: []
    }
}

const mutations = {
    [types.RECEIVE_CURRENT_DATE] (state, payload) {
        state.config.currentDate = payload
    },

    [types.RECEIVE_TOMORROW_DATE] (state, payload) {
        state.config.tomorrowDate = payload
    },

    [types.RECEIVE_AVAILABLE_DATES] (state, payload) {
        state.config.availableDates = payload
    }
}

const actions = {
    // ожидаемый формат даты "YYYY-MM-DD"
    receiveCurrentDate ({ state, commit, rootState }, payload) {
        commit(types.RECEIVE_CURRENT_DATE, payload)
    },

    // ожидаемый формат даты "YYYY-MM-DD"
    receiveTomorrowDate ({ state, commit, getters, rootState }, payload) {
        var tomorrow = payload.add(1, 'days')
        var tomorrowInRightFormat = tomorrow.format('YYYY-MM-DD')
        commit(types.RECEIVE_TOMORROW_DATE, tomorrowInRightFormat)
    },

    // получить список доступных дат размещений ВО ВСЕХ размещениях,
    // которые доступны В ТЕКУЩЕМ ТУРЕ
    receiveAvailableDates ({ state, commit, getters, rootState }) {
        let availableDates = []
        let accommodations = getters.accommodations
        for (let i in accommodations) {
            for(let j in accommodations[i].available) {
                if (accommodations[i].available[j].amount > 0) {
                    availableDates.push(accommodations[i].available[j].date)
                }
            }
        }
        commit(types.RECEIVE_AVAILABLE_DATES, availableDates)
    }
}

const getters = {
    // это не сегодняшний день
    // это день который на данный момент выбран в календаре
    currentDate (state, getters, rootState) {
        return state.config.currentDate
    },

    tomorrowDate (state, getters, rootState) {
        return state.config.tomorrowDate
    },

    availableDates (state, getters, rootState) {
        return state.config.availableDates
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}