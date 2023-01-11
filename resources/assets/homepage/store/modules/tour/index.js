import * as types from './mutation-types'

const state = {
    config: {
        info: null,
        id: null,
        adults: 2,
        children: 0,
        days: null,
        nights: null,
        totalPrice: 0,
        orderedRooms: {},
        flightCost: 2317,
        accomm: {},
        exactPrice: {},
        notes: '',
        totalPersons: {
            adults: 0,
            kids: 0,
            additional: 0
        }
    },
    order: {
        tour_id: null,
        date_in: null,
        cost: null,
        accommodations: {},
        currency_code: null,
        add_transfer: null,
        food: null,
        food_cost: null,
        flight_cost: null,
        transfer_cost: null,
        notes: null,
        email: null,
        mobile: null,
    },
    tourInProcess: false,
    tourFinished: false
};

const mutations = {
    [types.RECEIVE_NOTES](state, payload) {
        state.config.notes = payload
    },
    [types.RECEIVE_TOTAL_PERSONS](state, payload) {
        state.config.totalPersons = payload
    },
    [types.RECEIVE_TOUR_INFO](state, payload) {
        state.config.info = payload
    },
    [types.RECEIVE_TOUR_ID](state, payload) {
        state.config.id = payload
    },
    [types.RECEIVE_TOUR_ADULTS](state, payload) {
        state.config.adults = payload
    },
    [types.RECEIVE_TOUR_CHILDREN](state, payload) {
        state.config.children = payload
    },
    [types.RECEIVE_TOUR_DAYS](state, payload) {
        state.config.days = payload
    },
    [types.RECEIVE_TOUR_NIGHTS](state, payload) {
        state.config.nights = payload
    },
    [types.RECEIVE_TOUR_FLIGHT_COST](state, payload) {
        state.config.flightCost = payload
    },
    [types.RECEIVE_TOUR_TOTAL_PRICE](state, payload) {
        state.config.totalPrice = payload
    },
    [types.RECEIVE_TOUR_ORDERED_ROOMS](state, payload) {
        state.config.orderedRooms[payload.id] = payload.value
    },
    [types.RECEIVE_TOUR_ACCOMM](state, payload) {
        state.config.accomm[payload.id] = payload.value
    },
    [types.RECEIVE_EXACT_PRICE](state, payload) {
        state.config.exactPrice[payload.id] = payload.value
    },
    [types.REMOVE_TOUR_ORDERED_ROOMS](state, payload) {
        delete state.config.orderedRooms[payload]
    },
    setTourOrder(state, payload) {
        state.order = payload
    },
    setTourInProcess(state, payload) {
        state.tourInProcess = payload
    },
    setTourFinished(state, payload) {
        state.tourFinished = payload
    }
};

const actions = {
    receiveNotes({state, commit}, payload) {
        commit(types.RECEIVE_NOTES, payload)
    },
    receiveTotalPersons({state, commit, getters}, payload) {
        let accomm = getters.accomm;
        let result = {
            adults: 0,
            kids: 0,
            additional: 0
        };
        for (let i in accomm) {
            result.adults = result.adults + (accomm[i].adults === null ? 0 : parseInt(accomm[i].adults))
            result.kids = result.kids + (accomm[i].kids === null ? 0 : parseInt(accomm[i].kids))
            result.additional = result.additional + (accomm[i].additional === null ? 0 : parseInt(accomm[i].additional))
        }
        commit(types.RECEIVE_TOTAL_PERSONS, result)
    },
    receiveTourInfo({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_INFO, payload)
    },
    receiveTourId({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_ID, payload)
    },
    receiveTourAdults({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_ADULTS, payload)
    },
    receiveTourChildren({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_CHILDREN, payload)
    },
    receiveTourDays({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_DAYS, payload)
    },
    receiveTourNights({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_NIGHTS, payload)
    },
    receiveTourFlightCost({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_NIGHTS, payload)
    },
    receiveTourTotalPrice({state, commit, getters}) {
        let exactPrice = getters.exactPrice
        let tourDays = getters.tourDays
        let accomm = getters.accomm
        let feedingSelectedPrice = getters.feedingSelectedPrice === null ? 0 : getters.feedingSelectedPrice
        let transferPrice = parseFloat(getters.transferPrice)
        var transferPriceCurrent
        let transferChecked = getters.transferChecked

        var result = 0;

        if (transferChecked) {
            transferPriceCurrent = transferPrice
        } else {
            transferPriceCurrent = 0
        }

        for (let i in accomm) {
            let priceAdult = exactPrice[i].adults
            let priceKid = exactPrice[i].kids
            let priceAdditional = exactPrice[i].additional

            let adults = parseInt(accomm[i].adults) ? accomm[i].adults : 0
            let kids = parseInt(accomm[i].kids) ? accomm[i].kids : 0
            let additional = parseInt(accomm[i].additional) ? accomm[i].additional : 0

            result += (parseFloat(feedingSelectedPrice) + priceAdult) * adults;
            result += (parseFloat(feedingSelectedPrice) + priceKid) * kids;
            result += (parseFloat(feedingSelectedPrice) + priceAdditional) * additional;
        }

        result = result + transferPriceCurrent


        commit(types.RECEIVE_TOUR_TOTAL_PRICE, result);
    },
    receiveTourOrderedRooms({state, commit}, payload) {
        commit(types.RECEIVE_TOUR_ORDERED_ROOMS, payload)
    },
    receiveTourAccomm({state, commit, getters}, payload) {
        var localValue = payload.value ? parseInt(payload.value) : 0;
        var localPayload = {
            id: payload.id,
            value: {}
        };

        if (getters.accomm[payload.id]) {
            // в размещении уже что-то выбирали (существует)
            for (let item in getters.accomm[payload.id]) {
                if(item === payload.name) {
                    localPayload.value[item] = parseInt(localValue)
                } else {
                    localPayload.value[item] = getters.accomm[payload.id][item]
                }
            }
        } else {
            // первый выбор в размещении (не существует)
            switch (payload.name) {
                case "adults":
                    localPayload = {
                        id: payload.id,
                        value: {
                            adults: parseInt(localValue),
                            kids: 0,
                            additional: 0
                        }
                    };
                    break;
                case "kids":
                    localPayload = {
                        id: payload.id,
                        value: {
                            adults: 0,
                            kids: parseInt(localValue),
                            additional: 0
                        }
                    };
                    break;
                case "additional":
                    localPayload = {
                        id: payload.id,
                        value: {
                            adults: 0,
                            kids: 0,
                            additional: parseInt(localValue)
                        }
                    };
                    break;
                default:
                    localPayload = {
                        id: payload.id,
                        value: {
                            adults:0,
                            kids: 0,
                            additional: 0
                        }
                    };
            }
        }

        commit(types.RECEIVE_TOUR_ACCOMM, localPayload)
    },
    receiveExactPrice({state, commit}, payload) {
        commit(types.RECEIVE_EXACT_PRICE, payload)
    },
    removeTourOrderedRooms({state, commit}, payload) {
        commit(types.REMOVE_TOUR_ORDERED_ROOMS, payload)
    },
    sendTourOrder({state, commit}, payload) {
        //todo привязать роут динамически
        axios.post('/ru/tours', state.order)
            .then((response) => {
                if (response.data.success) {
                    commit('setTourFinished', true);
                } else {
                    commit('setMessage', {message: response.data.msg, type: 'error'});
                }
            })
            .catch((error) => {
                if (error.response.data.message) {
                    commit('setMessage', {message: error.response.data.message, type: 'error'});
                }
                if (error.response.data.errors) {
                    for (let i in error.response.data.errors) {
                        commit('setMessage', {message: error.response.data.errors[i], type: 'error'});
                    }
                }
                commit('setMessage', {message: error.message, type: 'error'});
            })
            .finally(() => {
                commit('setTourInProcess', false);
            });
    }
};

const getters = {
    totalPersons(state) {
        return state.config.totalPersons
    },

    tourInfo(state) {
        return state.config.info
    },

    tourId(state) {
        return state.config.id
    },

    tourAdults(state) {
        return state.config.adults
    },

    tourChildren(state) {
        return state.config.children
    },

    tourDays(state) {
        return state.config.days
    },

    tourNights(state) {
        return state.config.nights
    },

    tourTotalPrice(state) {
        return state.config.totalPrice
    },

    orderedRooms(state) {
        return state.config.orderedRooms
    },

    accomm(state) {
        return state.config.accomm
    },

    singleAccomm (state, getters, rootState) {
        return (id) => {
            return state.config.accomm[id]
        }
    },

    exactPrice(state) {
        return state.config.exactPrice
    },

    tourFlightCost(state) {
        return state.config.flightCost
    },

    notes(state) {
        return state.config.notes
    }
};

export default {
    state,
    mutations,
    actions,
    getters
}
