<template>
  <div class="container center-column">
    <AppHeader></AppHeader>
    <div class="outer-container center">
      <div class="waiting-container center-column">
        <div class="cut-number center-column bg-white border-radius border-solid">
          <p class="label">{{shopStatus}}</p>
          <p class="cut-now-number">{{cutNowNo}}</p>
        </div>
        <div class="waiting-people center-column bg-white border-radius border-solid">
          <p class="label">待ち人数</p>
          <p class="waiting-people-number">{{cutWaitingTotal}}人
            <span v-if="cutWaitNumberList.length > 0" class="waiting-time">(約{{waitingTime}}分待ち)</span>
            <span v-else class="waiting-time">(現在お待ちはいません)</span>
          </p>
        </div>
        <div class="now-time">
          <p class="time">{{nowTime}} 現在</p>
        </div>
        <div class="button-container center-column">
          <button v-on:click="toggleSidebar" class="button button-margin hover-cursor">待ち番号の一覧を表示</button>
          <button v-on:click="updateWaitingNo" class="button button-margin hover-cursor">最新の情報に更新</button>
        </div>
      </div>
    </div>
    <div id="sidebar" class="sidebar bg-black">
      <div v-on:click="toggleSidebar" class="close-button hover-cursor">
        <span class="closs-bar closs-bar-over bg-white"></span>
        <span class="closs-bar closs-bar-under bg-white"></span>
      </div>
      <div class="center-column">
        <div class="sidebar-number-container">
          <p class="sidebar-title white">お待ちの番号</p>
          <p class="sidebar-hint red">※赤は現在お呼び出し中の番号です。早めにお戻り下さい。</p>
          <div class="center-column">
            <div v-for="item in cutWaitNumberList" :key="item.id" class="waiting-number waiting-number-margin center border-radius"
              :class="{'bg-red' : item.isCutCall, 'bg-white' : !item.isCutCall}">
              {{item.waitingNo}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="isShopClose" class="center shop-close-container">
      <div class="center shop-close-item bg-black">
        <div class="center-column">
          <p class="label white">お知らせ</p>
          <p class="shop-close-message white">本日の営業は終了しました.</p>
          <p class="shop-close-message white">またのご来店をお待ちしております.</p>
          <button v-on:click="updateWaitingNo" class="shop-close-update-button hover-cursor">最新の情報に更新</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import header from '../components/Header'
export default {
  components: {
    AppHeader: header
  },
  created: async function() {
    await this.callApiGetWaitNumber()
    this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
    await this.updateCutStatus()
  },
  data() {
    return {
      shopStatus: '',
      nowTime: this.getNowTime(),
      cutWaitNumberList: this.$store.getters['waitingNoStateView'],
    }
  },
  computed: {
    cutNowNo() {
      return this.$store.getters['cutNowNo']
    },
    cutWaitingTotal() {
      return this.cutWaitNumberList.length
    },
    waitingTime() {
      return this.cutWaitNumberList.length * 20
    },
    isShopClose() {
      return this.$store.getters['shopStatus'] == 1
    },
  },
  methods: {
    getNowTime() {
      const now = new Date(Date.now())
      return ('00' + now.getHours().toString()).slice(-2) + ':' + ('00' + now.getMinutes().toString()).slice(-2)
    },
    async updateWaitingNo() {
      this.nowTime = this.getNowTime()
      await this.callApiGetWaitNumber()
      this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
      await this.updateCutStatus()
      this.$awn.info('最新の情報に更新しました.')
    },
    toggleSidebar() {
      const sidebar = document.getElementById('sidebar')
      sidebar.classList.toggle('show-sidebar')
    },
    async updateCutStatus() {
      await this.callAPIGetShopStatus()
      this.shopStatus = this.printShopStatus(this.$store.getters['shopStatus'])
    },
    printShopStatus(statusID) {
      switch (statusID) {
        case 1:
          return '営業終了'
        case 2:
          return '現在カット中の番号'
        case 3:
          return '準備中'
        default:
          return '-'
      }
    },
    async callApiGetWaitNumber() {
      let result = await axios.get(
          '/api/v1/waiting'
        ).catch(
          (error) => {
            this.$awn.alert('順番待ち番号の取得に失敗しました.')
            console.log(error)
          }
        )
      if (result !== undefined) {
        this.$store.dispatch('commitUpdateAPIWaitingNoState', {updateObject: result.data.wait_number})
      }
    },
    async callAPIGetShopStatus() {
      const result = await axios.get(
          '/api/v1/status'
        ).catch(
          (error) => {
            this.$awn.alert('店状態の取得に失敗しました.')
            console.log(error)
          }
        )
      if (result !== undefined) {
        this.$store.dispatch('commitUpdateShopStatus', {shopStatusID: result.data.status_id})
      } else {
        this.$store.dispatch('commitUpdateShopStatus', {shopStatusID: 0})
      }
    },
  },
  setup() {
    
  },
}
</script>

<style scoped>
  .container {
    position: relative;
  }
  .waiting-container{
    width: 570px;
    padding: 20px;
  }
  .cut-number {
    width: 100%;
    padding: 20px 0;
    margin-bottom: 20px;
  }
  .label {
    font-size: 1.5em;
    margin-bottom: 20px;
  }
  .cut-now-number {
    font-size: 3.0em;
  }
  .waiting-people {
    width: 100%;
    padding: 20px 0;
    margin-bottom: 20px;
  }
  .waiting-people-number {
    font-size: 2.0em;
  }
  .waiting-time {
    font-size: 0.8em;
  }
  .time {
    font-size: 1.5em;
    font-weight: bold;
    margin-bottom: 20px;
  }
  .sidebar {
    position: absolute;
    display: flex;
    flex-direction: column;
    width: 220px;
    height: 100vh;
    top: 0;
    left: -220px;
    transition: 0.5s;
    overflow-y: scroll;
  }
  .show-sidebar {
    transform: translateX(220px);
  }
  .sidebar-title {
    text-align: center;
    margin-bottom: 10px;
    font-size: 1.3em;
  }
  .sidebar-hint {
    margin-bottom: 20px;
  }
  .close-button {
    position: relative;
    width: 20px;
    height: 20px;
  }

  .closs-bar{
    position: absolute;
    display: inline-block;
    margin: 15px 0 0 15px;
    width: 20px;
    height: 2px;
  }
  .closs-bar-over {
    top: 10px;
    transform: rotate(45deg);
  }
  .closs-bar-under {
    top: 10px;
    transform: rotate(-45deg);
  }
  .sidebar-number-container {
    padding: 20px;
  }
  .waiting-number {
    width: 100%;
    height: 40px;
  }
  .waiting-number-margin:not(:first-of-type) {
    margin-top: 10px;
  }
  .shop-close-container {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 10;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.6);
  }
  .shop-close-item {
    width: 360px;
    padding: 20px;
    border-radius: 10px;
  }
  .shop-close-message {
    font-size: 1.2em;
  }
  .shop-close-message:not(:last-of-type) {
    margin-bottom: 5px;
  }
  .shop-close-update-button {
    font-size: 0.9em;
    margin-top: 10px;
    padding: 5px 20px;
  }
  .center-column {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  .center {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .hover-cursor:hover {
    cursor: pointer;
  }
  .button {
    padding: 10px 25px;
    font-size: 1.2em;
  }
  .button-margin:not(:last-of-type) {
    margin-bottom: 10px;
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
  .border-radius {
    border: 1px solid black;
    border-radius: 10px;
  }
  .border-solid {
    border: 1px solid black;
  }
  .lime {
    color: lime;
  }
  .white {
    color: white;
  }
  .red {
    color: red;
  }
  @media screen and (max-width: 768px) {
    .outer-container {
      width: 90%;
    }
    .waiting-container{
      width: 100%;
    }
  }
  @media screen and (max-width: 480px) {
    .outer-container {
      width: 95%;
    }
    .waiting-people-number {
      font-size: 1.7em;
    }
    .waiting-time {
      font-size: 0.8em;
    }
    .button {
      font-size: 1.1em;
    }
    .show-sidebar {
      transform: translateX(100%);
    }
    .sidebar {
      width: 100%;
      left: -100%;
    }
    .sidebar-title {
      font-size: 1.4em;
    }
    .closs-bar{
      width: 25px;
      height: 3px;
    }
    .sidebar-number-container {
      width: 70%;
      padding: 20px;
    }
    .waiting-number {
      width: 100%;
      height: 60px;
      font-size: 1.4em;
    }
    .shop-close-item {
      width: 75%;
      padding: 15px;
      border-radius: 10px;
    }
    .shop-close-message {
      font-size: 1.0em;
    }
    .shop-close-message:not(:last-of-type) {
      margin-bottom: 5px;
    }
    .shop-close-update-button {
      font-size: 0.9em;
      margin-top: 10px;
      padding: 3px 15px;
    }
  }
</style>