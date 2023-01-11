const state = {
    order: {
        excursion_id: null,
        excursion_availability_id: null,
        amount_adults: null,
        amount_kids: null,
        amount_child: null,
        amount_baby: null,
        group_pid: null,
        notes: null,
        email: null,
        mobile: null,
        options: []
    },
    excursionInProcess: false,
    excursionFinished: false
};

const mutations = {
    setExcursionOrder(state, payload) {
        state.order = payload
    },
    setExcursionInProcess(state, payload) {
        state.excursionInProcess = payload
    },
    setExcursionFinished(state, payload) {
        state.excursionFinished = payload
    }
};

const actions = {
    sendExcursionOrder({state, commit}, payload) {
        return new Promise((resolve, reject) => {
            //todo привязать роут динамически
            axios.post('/ru/excursions_booking', state.order)
                .then((response) => {
                    if (response.data.success) {
                        commit('setExcursionFinished', true);
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
                    commit('setExcursionInProcess', false);
                })
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
