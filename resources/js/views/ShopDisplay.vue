<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-controll-container">
      <div v-if="showSidebar" class="sidebar-space"></div>
      <div id="sidebar" class="sidebar">
        <div class="center-column">
          <div class="sidebar-number-container">
            <p class="sidebar-title white">待ち番号一覧</p>
            <!-- <p class="sidebar-hint red">※赤は現在お呼び出し中の番号です。早めにお戻り下さい。</p> -->
            <div class="waiting-number-list wrap-column">
              <div v-for="item in cutWaitNumberList" :key="item.id" class="waiting-number waiting-number-margin center border-radius"
                :class="{'bg-red' : item.isCutCall, 'bg-white' : !item.isCutCall}">
                {{item.waitingNo}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="information-group center-column">
        <div class="info-box waiting-box cutnow-info bg-white border-radius center-column">
          <p class="info-box-label">現在カット中の番号</p>
          <p class="info-box-number">{{cutNow}}</p>
        </div>
        <div class="info-box next-waiting-box bg-white border-radius center-column">
          <p class="info-box-label">お待ちの方は以下の番号札をお取り下さい</p>
          <p class="info-box-number">{{nextWaitingNo}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import header from '../components/Header.vue'
import axios from 'axios'
export default {
  components: {
    AppHeader: header
  },
  data() {
    return {
      cutWaitNoList: [],
      cutDoneNoList: [],
      cutCallNoList: [],
      cutNowNoList: [],
      updateWaitingNoState: [],
      cutWaitNumberList: [],
      showSidebar: false
    }
  },
  created: async function() {
    await this.callApiGetWaitNumber()
    this.updateLocalWaitingNo()
    if (this.$store.getters['cutNowNo'] !== '-') this.cutNowNoList.push(this.$store.getters['cutNowNo'])
    this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
  },
  mounted: function () {
    document.addEventListener('keydown', this.keydownEvent)
  },
  computed: {
    nextWaitingNo() {
      return this.$store.getters['nextWaitingNo']
    }
  },
  asyncComputed: {
    async cutNow() {
      if (this.cutNowNoList.length > 1) {
        this.cutDoneNoList.push(this.cutNowNoList.shift())
        if (this.cutDoneNoList.indexOf('-') !== -1) {
          this.removeEmptyNumber()
          await this.updateShopStatus(2)
        }
      } else if (this.cutNowNoList.length === 0) {
        this.cutNowNoList.push('-')
        await this.updateShopStatus(3)
        this.removeEmptyNumber()
      }
      this.waitingNoUpdate()
      return this.cutNowNoList[0]
    }
  },
  watch: {
    updateWaitingNoState: async function() {
      if (this.updateWaitingNoState.length > 0) {
        await this.callAPIUpdateWaitingNoState()
        this.$store.dispatch('commitResetUpdateFlg')
      }
    },
  },
  methods: {
    waitingNoUpdate() {
      this.sortCutWait()
      this.sortCutDone()
      this.sortCutCall()
      this.$store.dispatch('commitUpdateAdminWaitingNoState', {
        updateObject: {
          waitNoList: this.cutWaitNoList,
          doneNoList: this.cutDoneNoList,
          callNoList: this.cutCallNoList,
          nowNoList: this.cutNowNoList,
        }
      })
      this.updateWaitingNoState = this.$store.getters['updateWaitingNoState']
      this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
    },
    removeEmptyNumber() {
      this.cutDoneNoList.indexOf('-') !== -1 ?
        this.cutDoneNoList.splice(this.cutDoneNoList.indexOf('-'), 1) : ''
      this.cutWaitNoList.indexOf('-') !== -1 ?
        this.cutWaitNoList.splice(this.cutWaitNoList.indexOf('-'), 1) : ''
      this.cutCallNoList.indexOf('-') !== -1 ?
        this.cutCallNoList.splice(this.cutCallNoList.indexOf('-'), 1) : ''
    },
    sortCutDone() {
      this.cutDoneNoList.sort((a,b) => a < b ? 1 : -1)
    },
    sortCutWait() {
      this.cutWaitNoList.sort((a,b) => a > b ? 1 : -1)
    },
    sortCutCall() {
      this.cutCallNoList.sort((a,b) => a > b ? 1 : -1)
    },
    sessionOut() {
      let credential = {isLogin: false, accessToken: ''}
      this.$store.dispatch('commitUpdateLoginCredential', {credential})
      this.$router.push('login')
      console.log('info:The Login Token has not found in api server.')
    },
    updateLocalWaitingNo() {
      this.cutWaitNoList = this.$store.getters['cutWaitNoList']
      this.cutDoneNoList = this.$store.getters['cutDoneNoList']
      this.cutCallNoList = this.$store.getters['cutCallNoList']
    },
    async keydownEvent (event) {
      if (event.code === 'Numpad4') {
        this.toggleSidebar()
      } else if(event.code === 'Numpad8') {
        this.waitingToCutNow()
      } else if(event.code === 'Numpad2') {
        this.cutNowToWaiting()
      } else if(event.code === 'NumpadAdd') {
        await this.issueWaitingNo()
      } else if(event.code === 'NumpadSubtract') {
        await this.removeLatestWaitingNo()
      } else if(event.code === 'Numpad9') {
        this.waitingToCutCall()
      } else if(event.code === 'Numpad3') {
        this.cutCallToWaiting()
      } else if(event.code === 'Numpad7') {
        this.cutCallToCutNow()
      } else if(event.code === 'Numpad1') {
        this.cutNowToCutCall()
      } else if (event.code === 'Numpad5') {
        this.cutNowToCutDone()
      }
    },
    async updateShopStatus(shopStatusID) {
      await this.callAPIUpdateShopStatus(shopStatusID)
    },
    async issueWaitingNo() {
      await this.callAPIIssueWaitNumber()
      this.updateLocalWaitingNo()
      this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
    },
    async removeLatestWaitingNo() {
      let latestWaitingID = this.$store.getters['latestWaitingID']
      if (latestWaitingID > 0) {
        await this.callAPIRemoveWaitNumber(latestWaitingID)
        this.updateLocalWaitingNo()
        this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
      }
    },
    waitingToCutNow() {
      if (this.cutWaitNoList.length > 0) {
        this.cutNowNoList.push(this.cutWaitNoList.shift())
      }
    },
    cutNowToWaiting() {
      if (this.cutNowNoList[0] !== '-') {
        this.cutWaitNoList.push(this.cutNowNoList.shift())
        if (this.cutDoneNoList.length > 0) {
          this.cutNowNoList.push(this.cutDoneNoList.shift())
        }
      }
    },
    waitingToCutCall() {
      if (this.cutWaitNoList.length > 0) {
        this.cutCallNoList.push(this.cutWaitNoList.shift())
        if (this.cutNowNoList[0] === '-') this.waitingNoUpdate()
      }
    },
    cutCallToWaiting() {
      if (this.cutCallNoList.length > 0) {
        this.cutWaitNoList.push(this.cutCallNoList.shift())
        if (this.cutNowNoList[0] === '-') this.waitingNoUpdate()
      }

    },
    cutCallToCutNow() {
      if (this.cutCallNoList.length > 0) {
        this.cutNowNoList.push(this.cutCallNoList.shift())
      }
    },
    cutNowToCutCall() {
      if (this.cutNowNoList[0] !== '-') {
        this.cutCallNoList.push(this.cutNowNoList.shift())
        if (this.cutDoneNoList.length > 0) {
          this.cutNowNoList.push(this.cutDoneNoList.shift())
        }
      }
    },
    cutNowToCutDone() {
      if (this.cutNowNoList[0] !== '-' ) {
        this.cutDoneNoList.push(this.cutNowNoList.shift())
      } else if (this.cutDoneNoList.length > 0) {
        this.cutNowNoList.push(this.cutDoneNoList.shift())
      }
    },
    toggleSidebar() {
      const sidebar = document.getElementById('sidebar')
      sidebar.classList.toggle('show-sidebar')
      this.showSidebar = this.showSidebar ? false : true
    },
    apiErrorCode(axiosErrorMessage, errorMessages) {
      let errorCode = 0
      if (axiosErrorMessage !== undefined) {
        if (axiosErrorMessage.indexOf('Network Error') != -1) {
          errorCode = 1
        } else if(axiosErrorMessage.indexOf('status code 401') != -1){
          errorCode = 2
          this.sessionOut()
        } else {
          errorCode = 3
        }
        if (errorMessages !== undefined) {
          let errorMessage = errorMessages.filter(item => item.errorCode == errorCode)[0].errorMessage
          errorMessage !== undefined ? this.$awn.alert(errorMessage) : ''
        }
      }
      return errorCode
    },
    async callAPIUpdateShopStatus(statusID) {
      let axiosErrorMessage
      let errorMessages = [
        {errorCode: 1, errorMessage: '店状態の変更に失敗しました. ネットワーク接続を確認して下さい.'},
        {errorCode: 2, errorMessage: '店状態の変更に失敗しました. 再ログインして下さい.'},
        {errorCode: 3, errorMessage: '店状態の変更に失敗しました.'}
      ]
      const result = await axios.patch(
        '/api/v1/status', {
          'status_id': statusID
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('AccessToken')}`
          }
        }).catch(
          (error) => {
            axiosErrorMessage = error.message
            console.log(error)
          }
        )
      if (result !== undefined) {
        this.$store.dispatch('commitUpdateShopStatus', {shopStatusID: statusID})
      }
      return this.apiErrorCode(axiosErrorMessage, errorMessages)
    },
    async callAPIUpdateWaitingNoState() {
      let axiosErrorMessage
      let errorMessages = [
        {errorCode: 1, errorMessage: '順番待ち番号の更新に失敗しました. ネットワーク接続を確認して下さい.'},
        {errorCode: 2, errorMessage: '順番待ち番号の更新に失敗しました. 再ログインして下さい.'},
        {errorCode: 3, errorMessage: '順番待ち番号の更新に失敗しました.'}
      ]
      const result = await axios.patch(
        '/api/v1/waiting', {
          waiting_numbers: this.updateWaitingNoState
        }, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('AccessToken')}`
          }
        }).catch(
          (error) => {
            axiosErrorMessage = error.message
            console.log(error)
          }
        )
      if (result !== undefined) console.log('info:Update waitingNo successed.')
      return this.apiErrorCode(axiosErrorMessage, errorMessages)
    },
    async callAPIRemoveWaitNumber(waitingNoID) {
      let axiosErrorMessage
      let errorMessages = [
        {errorCode: 1, errorMessage: '順番待ち番号の削除に失敗しました. ネットワーク接続を確認してください.'},
        {errorCode: 2, errorMessage: '順番待ち番号の削除に失敗しました. 再ログインして下さい.'},
        {errorCode: 3, errorMessage: '順番待ち番号の削除に失敗しました.'}
      ]
      let result = await axios.delete(
          '/api/v1/waiting', {
            headers: {
              'Authorization': `Bearer ${localStorage.getItem('AccessToken')}`
            },
            data: {
              id: waitingNoID
            }
          }).catch(
          (error) => {
            axiosErrorMessage = error.message
            console.log(error)
          }
        )
      if (result !== undefined) {
        this.$store.dispatch('commitUpdateAPIWaitingNoState', {updateObject: result.data.wait_number})
        console.log('info:Remove waitingNo successed.')
      }
      return this.apiErrorCode(axiosErrorMessage, errorMessages)
    },
    async callAPIIssueWaitNumber() {
      let axiosErrorMessage
      let errorMessages = [
        {errorCode: 1, errorMessage: '順番待ち番号の発行に失敗しました. ネットワーク接続を確認してください.'},
        {errorCode: 2, errorMessage: '順番待ち番号の発行に失敗しました. 再ログインして下さい.'},
        {errorCode: 3, errorMessage: '順番待ち番号の発行に失敗しました.'}
      ]
      let result = await axios.post(
          '/api/v1/waiting', {}, {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('AccessToken')}`
          }
        }).catch(
          (error) => {
            axiosErrorMessage = error.message
            console.log(error)
          }
        )
      if (result !== undefined) {
        if (result.data.wait_number.length > 0) {
          this.$store.dispatch('commitUpdateAPIWaitingNoState', {updateObject: result.data.wait_number})
        } else {
          this.$store.dispatch('commitResetWaitingNoState')
        }
      }
      return this.apiErrorCode(axiosErrorMessage, errorMessages)
    },
    async callApiGetWaitNumber() {
      let axiosErrorMessage
      let errorMessages = [
        {errorCode: 1, errorMessage: '順番待ち番号の取得に失敗しました. ネットワーク接続を確認してください.'},
        {errorCode: 2, errorMessage: '順番待ち番号の取得に失敗しました. 再ログインして下さい.'},
        {errorCode: 3, errorMessage: '順番待ち番号の取得に失敗しました.'}
      ]
      let result = await axios.get(
          '/api/v1/waiting'
        ).catch(
          (error) => {
            axiosErrorMessage = error.message
            console.log(error)
          }
        )
      if (result !== undefined) {
        this.$store.dispatch('commitUpdateAPIWaitingNoState', {updateObject: result.data.wait_number})
      }
      return this.apiErrorCode(axiosErrorMessage, errorMessages)
    },
  },
  setup() {
    
  },
}
</script>

<style scoped>
  .outer-controll-container {
    width: 100%;
    display: flex;
    justify-content: space-around;
  }
  .sidebar-space {
    width: 20vw;
  }
  .information-group {
    width: 80vw;
  }
  .info-box {
    width: 90%;
    height: 360px;
  }
  .waiting-box {
    margin-top: 30px;
  }
  .next-waiting-box {
    margin-top: 60px;
  }
  .info-box-label {
    margin: 40px 0 10px 0;
    font-size: 3.0em;
  }
  .info-box-number {
    margin-top: 10px;
    font-size: 16.0em;
  }
  .sidebar {
    position: absolute;
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
    width: 20vw;
    height: calc(100vh - 150px);
    top: 150px;
    left: -20vw;
    transition: 0.5s;
    background: #333;
  }
  .show-sidebar {
    transform: translateX(20vw);
  }
  .sidebar-title {
    text-align: center;
    margin-bottom: 20px;
    font-size: 2.5em;
    padding-bottom: 10px;
    border-bottom: 2px dashed #CCC;
  }
  .sidebar-number-container {
    padding: 20px;
  }
  .waiting-number-list {
    height: calc(100vh - 280px)
  }
  .waiting-number {
    width: 45%;
    height: 60px;
    font-size: 2.0em;
  }
  .waiting-number-margin:not(:last-of-type) {
    margin-bottom: 10px;
  }
  button:hover {
    cursor: pointer;
  }
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .wrap-column {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-wrap: wrap;
  }
  .center-column {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .space-around {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
  }
  .border-radius {
    border: 1px solid black;
    border-radius: 10px;
  }
  .border-solid {
    border: 1px solid black;
  }
  .bg-white {
    background: white;
  }
  .bg-black {
    background: black;
  }
  .bg-red {
    background: red;
  }
  .white {
    color: white;
  }
  .red {
    color: red;
  }
</style>
