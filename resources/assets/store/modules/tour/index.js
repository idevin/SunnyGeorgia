const state = {
    order: {
        tour_id: null,
        date_in: null,
        cost: null,
        hotel: null,
        variant_name: null,
        adults: null,
        kids: null,
        email: null,
        mobile: null,
        currency_code: null,
    },
    tourInProcess: false,
    tourFinished: false
};

const mutations = {
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

    sendTourOrder({state, commit}, payload) {
        return new Promise((resolve, reject) => {
            //todo привязать роут динамически
            axios.post('/ru/tours', state.order)
                .then((response) => {
                    if (response.data.success) {
                        commit('setTourFinished', true);
                    } else {
                        commit('setMessage', {message: response.data.msg, type: 'error'});
                    }
                    resolve()
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
                    reject()
                })
                .finally(() => {
                    commit('setTourInProcess', false);
                });
        })
    }
};

const getters = {

};

export default {
    state,
    mutations,
    actions,
    getters
}
