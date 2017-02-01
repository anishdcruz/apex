import Vue from 'vue'
import Vuex from 'vuex'

import * as types from './types'
import { getByIndex, getByPath, store } from '../api'

Vue.use(Vuex)

const state = {
    model: {},
    loading: false,
    processing: false,
    errors: {},
    form: {
        items: []
    },
    option: {}
}

const actions = {
    fetchInvoices({commit, state}, payload) {
        commit(types.LOADING_BEGIN)
        getByPath(state.route, payload.path, function(data) {
            commit(types.SET_ITEMS, data)
            commit(types.LOADING_END)
        }, function(error) {

        })
    },
    fetchIndex({commit, state}, payload) {
        commit(types.LOADING_BEGIN)
        commit(types.CLEAN_UP)
        getByIndex(state.route, payload.resource, function(data) {
            commit(types.SET_MODEL, data)
            commit(types.LOADING_END)
        }, function(error) {

        })
    },
    fetchById({commit, state}, payload) {
        commit(types.LOADING_BEGIN)
        commit(types.CLEAN_UP)
        getByPath(state.route, payload.path, function(data) {
            commit(types.SET_MODEL, data)
            commit(types.LOADING_END)
        }, function(error) {

        })
    },
    fetchFormById({commit, state}, payload) {
        commit(types.LOADING_BEGIN)
        getByPath(state.route, payload.path, function(data) {
            commit(types.SET_FORM, data)
            commit(types.LOADING_END)
        }, function(error) {

        })
    },
    storeById({commit, state}, payload) {
        commit(types.PROCESS_BEGIN)
        commit(types.CLEAR_FORM_ERROR)
        store(payload, function(data) {
            commit(types.PROCESS_END)
            payload.router.push(payload.redirect)
        }, function(error) {
            console.log(error.status)
            if(error.status === 422) {
                commit(types.SET_FORM_ERROR, error)
            }
            commit(types.PROCESS_END)
        })
    }
}

const getters = {
    model(state) {
        return state.model
    },
    currency(state) {
        if(state.model.currency) {
            return state.model.currency
        }
        return {}
    },
    option(state) {
        return state.option
    },
    form(state) {
        return state.form
    },
    errors(state) {
        return state.errors
    },
    client(state) {
        if(state.model.client) {
            return state.model.client
        }
        return {}
    },
    sales(state) {
        if(state.model.sales) {
            return state.model.sales
        }
        return {}
    },
    deliveries(state) {
        if(state.model.deliveries) {
            return state.model.deliveries
        }
        return {}
    },
    payments(state) {
        if(state.model.payments) {
            return state.model.payments
        }
        return {}
    },
    vendor(state) {
        if(state.model.vendor) {
            return state.model.vendor
        }
        return {}
    }
}

const mutations = {
    [types.CLEAN_UP] (state, payload) {
        state.model = {}
        state.errors = {}
        state.form = {
            items: []
        }
        state.option = {}
    },
    [types.SET_FORM_ERROR] (state, payload) {
        state.errors = payload.data
    },
    [types.CLEAR_FORM_ERROR] (state, payload) {
        state.errors = {}
    },
    [types.SET_FORM] (state, payload) {
        state.option = payload.option
        state.form = payload.form
    },
    [types.SET_MODEL] (state, payload) {
        state.model = payload.model
    },
    [types.SET_ITEMS] (state, payload) {
        state.form.items = payload.items
    },
    [types.LOADING_BEGIN] (state) {
        state.loading = true
    },
    [types.LOADING_END] (state) {
        state.loading = false
    },
    [types.PROCESS_BEGIN] (state) {
        state.processing = true
    },
    [types.PROCESS_END] (state) {
        state.processing = false
    }
}

export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations
})