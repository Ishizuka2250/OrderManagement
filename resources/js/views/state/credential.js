import axios from "axios"

const state = {
  userID: '',
  isLogin: false,
}

const getters = {
  userID(state) {
    return state.userID
  },
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
    console.log(credential)
    state.userID = credential.userID
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
