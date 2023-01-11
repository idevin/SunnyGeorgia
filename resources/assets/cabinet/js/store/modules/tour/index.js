import * as types from './mutation-types'

const state = {
    tour: {
        images: []
    },
    translations: {},
    composer_places: {},
    optionGroups: null,
    tourPartner: null,
    tourUser: null
}

const mutations = {
    [types.RECEIVE_TOUR](state, payload) {
        state.tour = payload
    },

    [types.RECEIVE_TRANSLATIONS](state, payload) {
        state.translations[payload.locale] = payload.data
    },

    [types.RECEIVE_COMPOSER_PLACES](state, payload) {
        state.composer_places = payload
    },

    [types.RECEIVE_OPTION_GROUPS](state, payload) {
        state.optionGroups = payload
    },

    [types.DELETE_TOUR_IMAGE_BY_INDEX](state, payload) {
        state.tour.images.splice(payload.index, 1);
    },

    [types.RECEIVE_TOUR_PARTNER](state, payload) {
        state.tourPartner = payload
    },

    [types.RECEIVE_TOUR_USER](state, payload) {
        state.tourUser = payload
    },
}

const actions = {
    receiveTour({state, commit}, payload) {
        commit(types.RECEIVE_TOUR, payload)
    },

    receiveTranslations({state, commit, getters}, payload) {
        for (let i in getters.tour.translations) {
            commit(types.RECEIVE_TRANSLATIONS, {
                locale: getters.tour.translations[i].locale,
                data: getters.tour.translations[i]
            })
        }
    },

    receiveComposerPlaces({state, commit}, payload) {
        var arr = []
        for (let i in payload) {
            arr.push(payload[i])
        }
        commit(types.RECEIVE_COMPOSER_PLACES, arr)
    },

    receiveOptionGroups({state, commit}, payload) {
        commit(types.RECEIVE_OPTION_GROUPS, payload)
    },

    deleteTourImage({state, commit, getters}, payload) {
        var indx
        for (let i in getters.tour.images) {
            if (getters.tour.images[i].id == payload.id) {
                indx = i
            }
        }
        commit(types.DELETE_TOUR_IMAGE_BY_INDEX, {
            index: indx
        })
    },

    receiveTourPartner({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_PARTNER, payload)
    },

    receiveTourUser({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_USER, payload)
    }
}

const getters = {
    tour (state) {
        return state.tour
    },

    translations (state) {
        return state.translations
    },

    composerPlaces (state) {
        return state.composer_places
    },

    optionGroups (state) {
        return state.optionGroups
    },

    tourPartner (state) {
        return state.tourPartner
    },

    tourUser (state) {
        return state.tourUser
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}