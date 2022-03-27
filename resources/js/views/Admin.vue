<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-controll-container center">
      <div class="controll-container">
        <div class="button-list space-between">
          <button class="button">更新</button>
          <button v-on:click="reset" class="button">リセット</button>
          <button v-on:click="logout" class="button">ログアウト</button>
          <button v-on:click="shopClose" class="button">営業終了</button>
        </div>
        <div class="cut-status border-radius bg-white center">{{cutStatus}}</div>
        <Draggable v-model="cutNowNoList" group="cutNo" class="cut-number border-radius bg-white center">{{cutNow}}</Draggable>
        <button v-on:click="issueWaitNo" class="issue-Wait-button">受付番号発行</button>
        <div id="outer-number-list" class="space-between">
          <div class="number-list-box center-column">
            <div class="number-list-label center">カット済み</div>
            <div class="number-list-group border-solid">
              <Draggable v-model="cutDoneNoList" group="cutNo" class="number-list center-column">
                <div v-for="item in cutDoneNoList" :key="item.id" class="list-object list-object-margin border-radius bg-white center">
                  {{ item }}
                </div>
              </Draggable>
            </div>
          </div>
          <div class="number-list-box center-column">
            <div class="number-list-label center">待ち番号</div>
            <div class="number-list-group border-solid">
              <Draggable v-model="cutWaitNoList" group="cutNo" class="number-list center-column">
                <div v-for="item in cutWaitNoList" :key="item.id" class="list-object list-object-margin border-radius bg-white center">
                  {{ item }}
                </div>
              </Draggable>
            </div>
          </div>
          <div class="number-list-box center-column">
            <div class="number-list-label center">呼び出し中</div>
            <div class="number-list-group border-solid">
              <Draggable v-model="cutCallNoList" group="cutNo" class="number-list center-column">
                <div v-for="item in cutCallNoList" :key="item.id" class="list-object list-object-margin border-radius bg-white center">
                  {{ item }}
                </div>
              </Draggable>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import header from '../components/Header.vue'
import draggable from 'vuedraggable'
import credential from './state/credential'
export default {
  components: {
    AppHeader: header,
    Draggable: draggable
  },
  data() {
    return {
      cutStatus: this.$store.getters['cutStatus'],
      cutWaitNoList: this.$store.getters['cutWaitNoList'],
      cutDoneNoList: this.$store.getters['cutDoneNoList'],
      cutCallNoList: this.$store.getters['cutCallNoList'],
      cutNowNoList: ['-'],
    }
  },
  computed: {
    cutNow() {
      if (this.cutNowNoList.length > 1) {
        this.cutDoneNoList.push(this.cutNowNoList.pop())
        if (this.cutDoneNoList[0] === '-') {
          this.cutDoneNoList.pop()
          this.updateCutStatus('カット中')
        }
      }
      this.sortCutDone()
      this.sortCutWait()
      this.sortCutCall()
      this.updateOuterNoListHeight()
      this.$store.dispatch('updateWaitingNoState', {
        updateObject: {
          waitNoList: this.cutWaitNoList,
          doneNoList: this.cutDoneNoList,
          callNoList: this.cutCallNoList,
          nowNoList: this.cutNowNoList,
        }
      })
      console.log(this.$store.getters['waitingNoStatus'])
      return this.cutNowNoList[0]
    }
  },
  methods: {
    updateCutStatus(cutStatus) {
      this.$store.dispatch('updateCutStatus', {cutStatus: cutStatus})
      this.cutStatus = this.$store.getters['cutStatus']
    },
    reset() {
      this.cutStatus = '-'
      this.cutNowNoList[0] = '-'
      this.cutDoneNoList = []
      this.cutWaitNoList = []
      this.cutCallNoList = []
      this.$store.dispatch('resetWaitingNoState')
    },
    issueWaitNo() {
      //待ち番号発行apiに投げて新規番号を取得してcutWaitNoListにpush()
      this.$store.dispatch('addWaitingNoState')
      this.cutWaitNoList = this.$store.getters['cutWaitNoList']
      this.cutDoneNoList = this.$store.getters['cutDoneNoList']
      this.cutCallNoList = this.$store.getters['cutCallNoList']
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
    updateOuterNoListHeight() {
      let numberListLabels = document.getElementsByClassName('number-list-label')
      let numberListObjects = document.getElementsByClassName('list-object')
      let numberListLabelHeight = numberListLabels.length > 0 ? numberListLabels[0].clientHeight : 45
      let numberListObjectHeight =  numberListObjects.length > 0 ? numberListObjects[0].clientHeight : 42
      
      let maxObjectLength = this.cutWaitNoList.length > maxObjectLength ? this.cutWaitNoList.length : 0
      maxObjectLength = this.cutDoneNoList.length > maxObjectLength ? this.cutDoneNoList.length : maxObjectLength
      maxObjectLength = this.cutCallNoList.length > maxObjectLength ? this.cutCallNoList.length : maxObjectLength
      let outerNoList = document.getElementById('outer-number-list')
      if (outerNoList !== null) {
        outerNoList.style.height = numberListLabelHeight + ((numberListObjectHeight + 5) * maxObjectLength) + 30 + 'px'
      }
    },
    shopClose() {
      this.updateCutStatus('営業終了')
    },
    async logout() {
      await this.callAPILogout()
      if (!this.$store.getters['isLogin']) {
        console.log('info:System logout.')
        this.$router.push('login')
      }
    },
    async callAPILogout() {
      let result = await axios.delete(
        '/api/v1/logout', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('AccessToken')}`
          }
      }).catch(
        (error) => console.log(error)
      )
      if (result !== undefined) {
        if (result.data.success) {
          let credential = {
            isLogin: false,
            accessToken: ''
          }
          this.$store.dispatch('commitUpdateLoginCredential', {credential})
        }
      }
    }
  },
  setup() {
    
  },
}
</script>

<style scoped>
  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .controll-container{
    width: 570px;
    padding: 20px;
  }
  .button-list {
    margin-bottom: 20px;
  }
  .cut-status {
    height: 50px;
    margin-bottom: 20px;
    font-size: 1.5em;
  }
  .cut-number {
    height: 80px;
    margin-bottom: 20px;
    font-size: 3.0em;
  }
  #outer-number-list {
    height: 65px;
    margin-bottom: 20px;
  }
  .number-list-box {
    position: relative;
    width: 28%;
  }
  .number-list-label {
    position: absolute;
    top: 0;
    width: 90%;
    font-size: 1.5em;
    padding: 10px 0;
    background: #CCC;
    z-index: 5;
  }
  .number-list-group {
    position: absolute;
    width: 100%;
    top: calc(10px + (1.5em / 2));
    padding-top: calc(5px + (1.5em / 2));
  }
  .number-list {
    width: 100%;
    padding: 10px 0;
  }
  .list-object {
    width: 80%;
    padding: 10px 0;
    font-size: 1.2em;
  }
  .list-object-margin:not(:first-of-type) {
    margin-top: 5px;
  }
  .page-bottom-margin {
    margin-bottom: 20px;
  }
  .space-between {
    display: flex;
    justify-content: space-between;
  }
  .issue-Wait-button {
    width: 100%;
    font-size: 1.2em;
    padding: 10px 0;
    margin-bottom: 20px;
  }
  button:hover {
    cursor: pointer;
  }
  .button {
    padding: 10px 25px;
    font-size: 1.2em;
  }
  .bg-white {
    background: white;
  }
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
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
</style>
