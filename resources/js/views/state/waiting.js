const state = {
  shopStatus: 0,
  waitingNoState: []
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
  shopStatus(state) {
    return state.shopStatus
  },
  waitingNoStatus(state) {
    return state.waitingNoState
  },
  updateWaitingNoState(state) {
    return state.waitingNoState
      .filter(item => item.isUpdate)
      .map(item => {
        return {
          id: item.id,
          is_cut_wait: item.isCutWait,
          is_cut_done: item.isCutDone,
          is_cut_now: item.isCutNow,
          is_cut_call: item.isCutCall
      }})
  },
  cutNowNo(state) {
    let cutNowNo = state.waitingNoState
      .filter(item => item.isCutNow)
      .map(item => item.waitingNo)
    return cutNowNo.length > 0 ? ('00' + cutNowNo[0]).slice(-3) : '-'
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
  },
}

const actions = {
  commitUpdateAPIWaitingNoState({commit}, {updateObject: updateObject}){
    commit('resetWaitingNoState')
    commit('updateAPIWaitingNoState', {updateObject: updateObject})
  },
  commitUpdateAdminWaitingNoState({commit}, {updateObject: updateObject}) {
    commit('updateAdminWaitingNoState', {updateObject: updateObject})
  },
  commitUpdateShopStatus({commit}, {shopStatusID: shopStatusID}) {
    commit('updateShopStatus', {shopStatusID: shopStatusID})
  },
  commitResetUpdateFlg({commit}) {
    commit('resetUpdateFlg')
  },
}

const mutations = {
  updateShopStatus(state, {shopStatusID}) {
    state.shopStatus = shopStatusID
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
  updateAPIWaitingNoState(state, {updateObject}) {
    updateObject.forEach(waitingNo => {
      state.waitingNoState.push({
        id: waitingNo.id,
        waitingNo: waitingNo.waiting_no,
        isCutWait: waitingNo.is_cut_wait === 1 ? true : false,
        isCutDone: waitingNo.is_cut_done === 1 ? true : false,
        isCutCall: waitingNo.is_cut_call === 1 ? true : false,
        isCutNow: waitingNo.is_cut_now === 1 ? true : false,
        isUpdate: false
      })
    })
  },
  updateAdminWaitingNoState(state, {updateObject}) {
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