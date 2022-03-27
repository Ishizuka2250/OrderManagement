<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-login-container">
      <div class="login-container">
        <p class="login-header-text">管理者画面ログイン</p>
        <table>
          <tr>
            <th>UserName</th>
            <td><input class="input-box" type="text" v-model="email"></td>
          </tr>
          <tr>
            <th>Password</th>
            <td><input class="input-box" type="password" v-model="password"></td>
          </tr>
        </table>
        <div class="login-button-row">
          <button class="login-button" v-on:click="login">Login</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import header from '../components/Header.vue'
export default {
  components: {
    AppHeader: header
  },
  data() {
    return {
      email: '',
      password: ''
    }
  },
  created: async function() {
    //await this.$store.dispatch('commitInitLoginCheck')
    await this.apiInitLoginCheck()
    console.log(this.$store.getters['isLogin'])
  },
  methods: {
    login() {
      //console.log(this.email + '  ' + this.password)
      let accessToken = 'hoge'
      this.$store.dispatch('commitUpdateLoginCredential', {
        credential: {
          userID: this.email,
          accessToken: accessToken,
          isLogin: true
        }
      })
      this.$router.push('admin')
    },
    async apiInitLoginCheck() {
      let accessToken = localStorage.getItem('AccessToken')
      if (accessToken) {
        const result = await axios.get(
          'http://localhost:8000/api/v1/check', {
            headers: {
              'Authorization': `Bearer ${accessToken}`
              //'Authorization': 'Bearer 9|uP1oGqzbVRBsIdFCyPNyjdtD2L3ziZZ6hfIxnWVu'
              //Authorization: 'Bearer 1|2OZx3BuAPG3nDSXOc0HJFvP89llmNk82kW53V3CW'
            }
          }).catch(
            function(error) {
              console.log(error)
            }
          )
        //console.log(result.data.login_user.email)
        const credential = {
          userID: '',
          isLogin: false,
          accessToken: ''
        }
        if (result !== undefined) {
          const credential = {
            userID: result.data.login_user.email,
            isLogin: result.data.success === 1 ? true : false,
            accessToken: accessToken
          }
        }
        this.$store.dispatch('commitUpdateLoginCredential', {credential})
      }
    }
  }
}
</script>

<style>
  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .outer-login-container{
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 100px;
  }
  .login-container{
    display: inline-block;
    padding: 20px;
    background: white;
    border-radius: 10px;
  }
  .login-header-text {
    margin-bottom: 10px;
    text-align: center;
    font-size: 1.3em;
    font-weight: bold;
  }
  tr th {
    padding: 10px;
    font-size: 1.1em;
  }
  tr td {
    padding: 10px;
  }
  .input-box {
    padding: 10px;
    font-size: 1.1em;
  }
  .login-button-row {
    margin-top: 10px;
    display: flex;
    flex-direction: row-reverse;
  }
  .login-button {
    display: inline-block;
    margin-right: 10px;
    padding: 5px 15px;
    font-size: 1.1em;
  }
</style>