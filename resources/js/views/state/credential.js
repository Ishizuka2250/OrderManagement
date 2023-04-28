import axios from "axios"

const state = {
  isLogin: false,
  masterKey: ''
}

const getters = {
  isLogin(state) {
    return state.isLogin
  },
  masterKey(state) {
    return state.masterKey
  }
}

const actions = {
  commitUpdateLoginCredential({commit}, {credential: credential}) {
    commit('updateLoginCredential', {credential: credential})
  },
  async apiCallLoginCheck({commit}) {
    let accessToken = localStorage.getItem('AccessToken')
    let credential = {
      isLogin: false,
      masterKey: '',
      accessToken: ''
    }
    if (accessToken) {
      const result = await axios.get(
        '/api/v1/auth/check', {
          headers: {
            'Authorization': `Bearer ${accessToken}`
          }
        }).catch(
          (error) => console.log('info:The Old Access Token has been deleted due to session timeout.')
        )
      if (result !== undefined) {
          if (result.data.success) {
            credential.isLogin = true
            credential.masterKey = result.data.login_user.master_key
            credential.accessToken = accessToken
          }
      }
    }
    commit('updateLoginCredential', {credential: credential})
  }
}

const mutations = {
  updateLoginCredential(state, {credential}) {
    state.isLogin = credential.isLogin
    state.masterKey = credential.masterKey
    localStorage.setItem('AccessToken', credential.accessToken)
  },
}

export default {
  state,
  getters,
  actions,
  mutations
}
