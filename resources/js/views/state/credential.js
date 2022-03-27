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
  async commitInitLoginCheck({commit}) {
    await commit('apiInitLoginCheck')
  }
}

const mutations = {
  updateLoginCredential(state, {credential}) {
    state.userID = credential.userID
    state.isLogin = credential.isLogin
    localStorage.setItem('AccessToken', credential.accessToken)
  },
  async apiInitLoginCheck(state) {
    let accessToken = localStorage.getItem('AccessToken')
    if (accessToken) {
      const result = await axios.get(
        'http://localhost:8000/api/v1/check', {
          headers: {
            //'Authorization': `Bearer ${accessToken}`
            'Authorization': 'Bearer 9|uP1oGqzbVRBsIdFCyPNyjdtD2L3ziZZ6hfIxnWVu'
          }
        }).catch(
          function(error) {
            console.log(error)
          }
        )
      if (result !== undefined) {
        state.isLogin = result.data.success === 1 ? true : false
      }
    }
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
