<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-controll-container center">
      <div class="controll-container">
        <div class="button-list space-between">
          <button class="button">更新</button>
          <button v-on:click="reset" class="button">リセット</button>
          <button class="button">ログアウト</button>
          <button class="button">営業終了</button>
        </div>
        <div class="cut-status border-radius bg-white center">{{cutStatus}}</div>
        <Draggable v-model="cutNowNumberList" group="cutNumber" class="cut-number border-radius bg-white center">{{cutNow}}</Draggable>
        <button class="issue-Wait-button">受付番号発行</button>
        <div class="space-between">
          <div class="number-list-box center-column">
            <div class="number-list-label center">カット済み</div>
            <div class="number-list-group border-solid">
              <Draggable v-model="cutDoneNumberList" group="cutNumber" class="number-list center-column">
                <div v-for="item in cutDoneNumberList" :key="item.id" class="list-object list-object-margin border-radius bg-white center">
                  {{ item }}
                </div>
              </Draggable>
            </div>
          </div>
          <div class="number-list-box center-column">
            <div class="number-list-label center">待ち番号</div>
            <div class="number-list-group border-solid">
              <Draggable v-model="cutWaitNumberList" group="cutNumber" class="number-list center-column">
                <div v-for="item in cutWaitNumberList" :key="item.id" class="list-object list-object-margin border-radius bg-white center">
                  {{ item }}
                </div>
              </Draggable>
            </div>
          </div>
          <div class="number-list-box center-column">
            <div class="number-list-label center">呼び出し中</div>
            <div class="number-list-group border-solid">
              <Draggable v-model="cutCallNumberList" group="cutNumber" class="number-list center-column">
                <div v-for="item in cutCallNumberList" :key="item.id" class="list-object list-object-margin border-radius bg-white center">
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
export default {
  components: {
    AppHeader: header,
    Draggable: draggable
  },
  data() {
    return {
      cutStatus: 'カット中',
      cutNowNumberList: ['010'],
      cutDoneNumberList: ['009', '007', '008'],
      cutWaitNumberList: ['012', '011'],
      cutCallNumberList: ['003', '002']
    }
  },
  computed: {
    cutNow() {
      if (this.cutNowNumberList.length > 1) {
        this.cutDoneNumberList.push(this.cutNowNumberList.pop());
      }
      this.sortCutDone();
      this.sortCutWait();
      this.sortCutCall();
      return this.cutNowNumberList[0];
    }
  },
  methods: {
    reset() {
      this.cutStatus = '-';
      this.cutNowNumberList[0] = '-';
      this.cutDoneNumberList = [];
      this.cutWaitNumberList = [];
      this.cutCallNumberList = [];
    },
    issueWaitNumber() {
      //待ち番号発行apiに投げて新規番号を取得してcutWaitNumberListにpush()
    },
    sortCutDone() {
      this.cutDoneNumberList.sort((a,b) => a < b ? 1 : -1);
    },
    sortCutWait() {
      this.cutWaitNumberList.sort((a,b) => a > b ? 1 : -1);
    },
    sortCutCall() {
      this.cutCallNumberList.sort((a,b) => a > b ? 1 : -1);
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
