import axios from "axios"

const state = {
  isLogin: false,
}

const getters = {
  isLogin(state) {
    return state.isLogin
  }
}

const actions = {
  commitUpdateLoginCredential({commit}, {credential: credential}) {
    commit('updateLoginCredential', {credential: credential})
  },
}

const mutations = {
  updateLoginCredential(state, {credential}) {
    state.isLogin = credential.isLogin
    localStorage.setItem('AccessToken', credential.accessToken)
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
