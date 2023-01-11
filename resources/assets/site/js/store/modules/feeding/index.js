import * as types from './mutation-types'
import * as api   from '../../../api'

const state = {
    config: {
        optionsList: null,
        availability: null,
        isFreeFeedingExist: null,
        freeFeedingId: null,
        defaultSelectedFeedingId: null,
        selectedFeedingId: null,
        selectedFeedingPrice: null,
        selectedFeedingType: null
    }
}

const mutations = {
    [types.RECEIVE_FEEDING_OPTIONS_LIST] (state, payload) {
        state.config.optionsList = payload
    },

    [types.RECEIVE_FEEDING_AVAILABILITY] (state, payload) {
        state.config.availability = payload
    },

    [types.RECEIVE_FEEDING_FREE_EXIST] (state, payload) {
        state.config.isFreeFeedingExist = payload
    },

    [types.RECEIVE_FEEDING_FREE_ID] (state, payload) {
        state.config.freeFeedingId = payload
    },

    [types.RECEIVE_FEEDING_SELECTED_ID] (state, payload) {
        state.config.selectedFeedingId = payload
    },

    [types.RECEIVE_FEEDING_SELECTED_PRICE] (state, payload) {
        state.config.selectedFeedingPrice = payload
    },

    [types.RECEIVE_FEEDING_SELECTED_TYPE] (state, payload) {
        state.config.selectedFeedingType = payload
    },

    [types.RECEIVE_FEEDING_DEFAULT_SELECTED_ID] (state, payload) {
        state.config.defaultSelectedFeedingId = payload
    }
}

const actions = {
    receiveOptionsList ({ state, commit }, payload) {
        commit(types.RECEIVE_FEEDING_OPTIONS_LIST, payload)
    },

    // если с бека в OptionsList пришел пустой объект - это означает что Питание ВООБЩЕ НЕ ПРЕДУСМОТРЕНО в этом туре,
    // в других случаях приходит объект с данными
    receiveFeedingAvailability ({ state, commit, getters }) {
        if ( api.isEmpty(getters.feedingOptionsList) ) {
            commit(types.RECEIVE_FEEDING_AVAILABILITY, false)
        } else {
            commit(types.RECEIVE_FEEDING_AVAILABILITY, true)
        }
    },

    // если в списке опций - есть айтем с ценой == 0,
    // то бесплатная еда существует
    receiveFreeFeedingExist ({ state, commit, getters }) {
        var flag = false
        if(getters.feedingAvailability) {
            for (let i in getters.feedingOptionsList) {
                let localPrice = parseInt(getters.feedingOptionsList[i].local_price)
                let localId = getters.feedingOptionsList[i].id
                let title = getters.feedingOptionsList[i].title
                if (localPrice == 0 || localPrice === null) {
                    localPrice = 0
                    flag = true
                    commit(types.RECEIVE_FEEDING_FREE_ID, localId)
                    commit(types.RECEIVE_FEEDING_DEFAULT_SELECTED_ID, localId)
                    commit(types.RECEIVE_FEEDING_SELECTED_ID, localId)
                    commit(types.RECEIVE_FEEDING_SELECTED_PRICE, localPrice)
                    commit(types.RECEIVE_FEEDING_SELECTED_TYPE, title)
                }
            }
        }
        commit(types.RECEIVE_FEEDING_FREE_EXIST, flag)
    },

    // определяет дефолтный ID для того что бы отметить значение по умолчанию
    // если питание доступно и нет бесплатного варианта питания,
    // то выбираем первый айтем в объекте feedingOptionsList
    receiveFeedingDefaultSelectedId ({ state, commit, getters }) {
        if (getters.feedingAvailability && !getters.feedingFreeExist) {
            for (let i in getters.feedingOptionsList) {
                commit(types.RECEIVE_FEEDING_DEFAULT_SELECTED_ID, getters.feedingOptionsList[i].id)
                commit(types.RECEIVE_FEEDING_SELECTED_ID, getters.feedingOptionsList[i].id)
                commit(types.RECEIVE_FEEDING_SELECTED_PRICE, getters.feedingOptionsList[i].local_price)
                commit(types.RECEIVE_FEEDING_SELECTED_TYPE, getters.feedingOptionsList[i].title)
                break
            }
        }
    },

    receiveFreeFeedingId ({ state, commit, getters }, payload) {
        commit(types.RECEIVE_FEEDING_FREE_ID, payload)
    },

    receiveSelectedFeedingId ({ state, commit, getters }, payload) {
        commit(types.RECEIVE_FEEDING_SELECTED_ID, payload)
    },

    receiveSelectedFeedingPrice ({ state, commit, getters }, payload) {
        commit(types.RECEIVE_FEEDING_SELECTED_PRICE, payload)
    },

    receiveSelectedFeedingType ({ state, commit, getters }, payload) {
        commit(types.RECEIVE_FEEDING_SELECTED_TYPE, payload)
    },

    receiveDefaultSelectedFeedingId ({ state, commit, getters }, payload) {
        commit(types.RECEIVE_FEEDING_DEFAULT_SELECTED_ID, payload)
    },
}

const getters = {
    feedingOptionsList (state) {
        return state.config.optionsList
    },

    feedingAvailability (state) {
        return state.config.availability
    },

    feedingFreeExist (state) {
        return state.config.isFreeFeedingExist
    },

    feedingFreeId (state) {
        return state.config.freeFeedingId
    },

    feedingSelectedId (state) {
        return state.config.selectedFeedingId
    },

    feedingSelectedPrice (state) {
        return state.config.selectedFeedingPrice
    },

    feedingSelectedType (state) {
        return state.config.selectedFeedingType
    },

    defaultSelectedFeedingId (state) {
        return state.config.defaultSelectedFeedingId
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}