<template>
  <div class="container center-column">
    <AppHeader></AppHeader>
    <div class="outer-container center">
      <div class="waiting-container center-column">
        <div class="cut-number center-column bg-white border-radius border-solid">
          <p class="label">カット中の番号</p>
          <p class="cut-now-number">{{cutNowNumber}}</p>
        </div>
        <div v-on:click="toggleSidebar" class="waiting-people center-column bg-white border-radius border-solid">
          <p class="label">お待ち人数</p>
          <p class="waiting-people-number">{{waitingPeopleNumber}}人</p>
        </div>
        <p class="hint">(待ち人数をタップすると待ち番号の一覧が表示されます)</p>
        <div class="now-time">
          <p class="time"><span class="lime">{{nowTime}}</span> 現在</p>
        </div>
        <div class="button-container center-column">
          <button v-on:click="updateWaitingNo" class="button hover-cursor">最新の情報に更新</button>
        </div>
      </div>
    </div>
    <div id="sidebar" class="sidebar bg-black">
      <div v-on:click="toggleSidebar" class="close-button hover-cursor">
        <span class="closs-bar closs-bar-over bg-white"></span>
        <span class="closs-bar closs-bar-under bg-white"></span>
      </div>
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
</template>

<script>
import header from '../components/Header'
export default {
  components: {
    AppHeader: header
  },
  data() {
    return {
      cutNowNumber: '001',
      waitingPeopleNumber: 4,
      nowTime: this.getNowTime(),
      cutWaitNumberList: this.$store.getters['waitingNoStateView']
    }
  },
  methods: {
    getNowTime() {
      const now = new Date(Date.now())
      return ('00' + now.getHours().toString()).slice(-2) + ':' + ('00' + now.getMinutes().toString()).slice(-2)
    },
    updateWaitingNo() {
      this.nowTime = this.getNowTime()
      this.$store.dispatch('updateWaitingNoState', {})
      this.cutWaitNumberList = this.$store.getters['waitingNoStateView']
    },
    toggleSidebar() {
      const sidebar = document.getElementById('sidebar')
      sidebar.classList.toggle('show-sidebar')
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
    margin-bottom: 5px;
  }
  .hint {
    margin-bottom: 30px;
  }
  .waiting-people:hover {
    cursor: pointer;
  }
  .waiting-people-number {
    font-size: 2.0em;
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
    color:lime;
  }
  .white {
    color: white;
  }
  .red {
    color: red;
  }

</style>