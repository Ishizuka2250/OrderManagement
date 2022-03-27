import Vue from 'vue'
import Vuex from 'vuex'
import Waiting from './views/state/waiting'
import Credential from './views/state/credential'

Vue.use(Vuex)

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  modules: {Waiting, Credential},
  state: {},
  mutations: {},
  actions: {}
})
