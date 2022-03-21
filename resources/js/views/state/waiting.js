import axios from "axios"

const state = {
  cutStatus: '-',
  waitingNoState: [
  {
    id: 1,
    waitingNo: 1,
    isCutWait: false,
    isCutDone: false,
    isCutCall: true,
    isCutNow: false,
    isUpdate: false
  },
  {
    id: 2,
    waitingNo: 2,
    isCutWait: true,
    isCutDone: false,
    isCutCall: false,
    isCutNow: false,
    isUpdate: false
  },
  ]
  // {
  //   id: ,
  //   waitingNo: ,
  //   isCutWait: ,
  //   isCutDone: ,
  //   isCutCall: ,
  //   isCutNow: ,
  //   isUpdate:
  // },
}

const getters = {
  waitingNoStatus(state) {
    return state.waitingNoState
  },
  cutStatus(state) {
    return state.cutStatus
  },
  cutWaitNoList(state) {
    return state.waitingNoState
      .filter(item => item.isCutWait)
      .map(item => ('00' + item.waitingNo).slice(-3))
  },
  cutDoneNoList(state) {
    return state.waitingNoState
      .filter(item => item.isCutDone)
      .map(item => ('00' + item.waitingNo).slice(-3))
  },
  cutCallNoList(state) {
    return state.waitingNoState
      .filter(item => item.isCutCall)
      .map(item => ('00' + item.waitingNo).slice(-3))
  },
  waitingNoStateView(state) {
    let waitingNoAndCallNoList = []
    state.waitingNoState
      .filter(item => item.isCutCall)
      .forEach(item => waitingNoAndCallNoList.push({
        waitingNo: ('00' + item.waitingNo).slice(-3),
        isCutCall: true
      }))
    state.waitingNoState
      .filter(item => item.isCutWait)
      .forEach(item => waitingNoAndCallNoList.push({
        waitingNo: ('00' + item.waitingNo).slice(-3),
        isCutCall: false
      }))
    return waitingNoAndCallNoList
  }
}

const actions = {
  async updateWaitingNoState({dispatch}, {updateObject: updateObject}) {
    console.log(updateObject)
    if (updateObject !== undefined) {
      await dispatch('commitUpdateAdminWaitingNoState', {updateObject: updateObject})
      await dispatch('commitResetUpdateFlg')
    }
    //サーバ側とのAPI通信
  },
  commitUpdateAdminWaitingNoState({commit}, {updateObject: updateObject}) {
    commit('updateAdminWaitingNoState', {updateObject: updateObject})
  },
  async addWaitingNoState({dispatch}) {
    await dispatch('commitAddWaitingNoState')
    //サーバ側とのAPI通信
    await dispatch('commitResetUpdateFlg')
  },
  commitAddWaitingNoState({commit}) {
    commit('addWaitingNoState')
  },
  async resetWaitingNoState({dispatch}) {
    await dispatch('commitResetWaitingNoState')
    //サーバ側とのAPI通信
  },
  commitResetWaitingNoState({commit}) {
    commit('resetWaitingNoState')
  },
  async updateCutStatus({dispatch}, {cutStatus: cutStatus}) {
    await dispatch('commitUpdateCutStatus', {cutStatus: cutStatus})
    //サーバ側とのAPI通信
  },
  commitUpdateCutStatus({commit}, {cutStatus: cutStatus}) {
    commit('updateCutStatus', {cutStatus: cutStatus})
  },
  commitResetUpdateFlg({commit}) {
    commit('resetUpdateFlg')
  }
}

const mutations = {
  updateCutStatus(state, {cutStatus}) {
    state.cutStatus = cutStatus
  },
  addWaitingNoState(state) {
    let id = 0
    state.waitingNoState.forEach(item => {
      id = item.id > id ? item.id : id
    })
    let waitingNo = 0
    state.waitingNoState.forEach(item => {
      waitingNo = item.waitingNo > waitingNo ? item.waitingNo : waitingNo
    })
    state.waitingNoState.push({
      id: id + 1,
      waitingNo: waitingNo + 1,
      isCutWait: true,
      isCutDone: false,
      isCutCall: false,
      isCutNow: false,
      isUpdate: true
    })
  },
  resetWaitingNoState(state) {
    state.waitingNoState = []
  },
  resetUpdateFlg(state) {
    let updatedWaitingNoState = state.waitingNoState.filter(item => item.isUpdate)
    updatedWaitingNoState.forEach(item => {
      for(let i = 0; i < state.waitingNoState.length; i++) {
        state.waitingNoState[i].isUpdate = item.id === state.waitingNoState[i].id
          ? false : state.waitingNoState[i].isUpdate
      }
    })
  },
  async updateAdminWaitingNoState(state, {updateObject}) {
    updateObject.waitNoList.forEach(waitingNo => {
      let update = 0
      for(let i = 0; i < state.waitingNoState.length; i++) {
        if (parseInt(waitingNo) === state.waitingNoState[i].waitingNo) {
          if (!state.waitingNoState[i].isCutWait) {
            state.waitingNoState[i].isCutWait = true;update++
          }
          if (state.waitingNoState[i].isCutDone) {
            state.waitingNoState[i].isCutDone = false;update++
          }
          if (state.waitingNoState[i].isCutCall) {
            state.waitingNoState[i].isCutCall = false;update++
          }
          if (state.waitingNoState[i].isCutNow) {
            state.waitingNoState[i].isCutNow = false;update++
          }
          state.waitingNoState[i].isUpdate = update > 0 ? true : state.waitingNoState[i].isUpdate
        }
      }
    })

    updateObject.doneNoList.forEach(waitingNo => {
      for(let i = 0; i < state.waitingNoState.length; i++) {
        let update = 0
        if (parseInt(waitingNo) === state.waitingNoState[i].waitingNo) {
          if (state.waitingNoState[i].isCutWait) {
            state.waitingNoState[i].isCutWait = false;update++
          }
          if (!state.waitingNoState[i].isCutDone) {
            state.waitingNoState[i].isCutDone = true;update++
          }
          if (state.waitingNoState[i].isCutCall) {
            state.waitingNoState[i].isCutCall = false;update++
          }
          if (state.waitingNoState[i].isCutNow) {
            state.waitingNoState[i].isCutNow = false;update++
          }
          state.waitingNoState[i].isUpdate = update > 0 ? true : state.waitingNoState[i].isUpdate
        }
      }
    })

    updateObject.callNoList.forEach(waitingNo => {
      for(let i = 0; i < state.waitingNoState.length; i++) {
        let update = 0
        if (parseInt(waitingNo) === state.waitingNoState[i].waitingNo) {
          if (state.waitingNoState[i].isCutWait) {
            state.waitingNoState[i].isCutWait = false;update++
          }
          if (state.waitingNoState[i].isCutDone) {
            state.waitingNoState[i].isCutDone = false;update++
          }
          if (!state.waitingNoState[i].isCutCall) {
            state.waitingNoState[i].isCutCall = true;update++
          }
          if (state.waitingNoState[i].isCutNow) {
            state.waitingNoState[i].isCutNow = false;update++
          }
          state.waitingNoState[i].isUpdate = update > 0 ? true : state.waitingNoState[i].isUpdate
        }
      }
    })

    let waitingNo = updateObject.nowNoList[0] !== '-' ? parseInt(updateObject.nowNoList[0]) : 0
    for(let i = 0; i < state.waitingNoState.length; i++) {
      let update = 0
      if (waitingNo === state.waitingNoState[i].waitingNo) {
        if (state.waitingNoState[i].isCutWait) {
          state.waitingNoState[i].isCutWait = false;update++
        }
        if (state.waitingNoState[i].isCutDone) {
          state.waitingNoState[i].isCutDone = false;update++
        }
        if (state.waitingNoState[i].isCutCall) {
          state.waitingNoState[i].isCutCall = false;update++
        }
        if (!state.waitingNoState[i].isCutNow) {
          state.waitingNoState[i].isCutNow = true;update++
        }
        state.waitingNoState[i].isUpdate = update > 0 ? true : state.waitingNoState[i].isUpdate
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