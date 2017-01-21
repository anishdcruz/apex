import Vue from 'vue'
import Vuex from 'vuex'

import * as types from './types'
import { getByIndex } from '../api'

Vue.use(Vuex)

const state = {
    model: {},
    loading: false,
    errors: [],
    form: {}
}

const actions = {
    fetchIndex({commit, state}, payload) {
        commit(types.LOADING_BEGIN)
        getByIndex(state.route, payload.resource, function(data) {
            commit(types.SET_MODEL, data)
            commit(types.LOADING_END)
        }, function(errror) {

        })
    }
}

const getters = {
    model(state) {
        return state.model
    }
}

const mutations = {
    [types.SET_MODEL] (state, payload) {
        state.model = payload.model
    },
    [types.LOADING_BEGIN] (state) {
        state.loading = true
    },
    [types.LOADING_END] (state) {
        state.loading = false
    }
}

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations
})