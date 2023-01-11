import * as types from './mutation-types'

const state = {
    config: {
        options: {
            default: {
                theme: 'bubble',
                position: 'bottom-center'
            }
        }
    },
    messages: []
};

const mutations = {
    setMessage (state, payload) {
        let type = payload.type ? payload.type : 'success';
        let message = payload.message ? payload.message : payload;
        state.messages.push({type, message})
    },
    popMessage(state){
        state.messages.pop()
    }
};

const actions = {

}

const getters = {
    notificationOptions (state, getters, rootState) {
        return state.config.options
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}
