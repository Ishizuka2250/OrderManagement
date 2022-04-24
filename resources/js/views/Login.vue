<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-login-container">
      <div class="login-container">
        <p class="login-header-text">管理者画面ログイン</p>
        <table>
          <tr>
            <th>UserName</th>
            <td><input class="input-box" type="text" v-model="email" maxlength="255"></td>
          </tr>
          <tr>
            <th>Password</th>
            <td><input class="input-box" type="password" v-model="password" maxlength="16"></td>
          </tr>
        </table>
        <div class="login-button-row">
          <button class="button" v-on:click="login">Login</button>
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
    await this.apiCallLoginCheck()
    if (this.$store.getters['isLogin']) {
      this.$router.push('admin')
      this.$awn.info('自動ログインしました.')
      console.log('info:System auto login.')
    }
  },
  methods: {
    async login() {
      await this.apiCallLoginCredential(this.email, this.password)
      if (this.$store.getters['isLogin']) {
        this.$router.push('admin')
        this.$awn.success('ログインしました.')
        console.log('info:System login.')
      }
    },
    async apiCallLoginCredential(email, password) {
      let credential = {
        isLogin: false,
        accessToken: ''
      }
      let result = await axios.post(
        '/api/v1/auth/login', {
          email: email,
          password: password
        }).catch(
          (error) => {
            this.$awn.alert('ログイン認証に失敗しました.')
            console.log(error)
          }
        )
      if (result !== undefined) {
        if (result.data.success) {
          credential.isLogin = true
          credential.accessToken = result.data.access_token
        }
      }
      this.$store.dispatch('commitUpdateLoginCredential', {credential})
    },
    async apiCallLoginCheck() {
      let accessToken = localStorage.getItem('AccessToken')
      let credential = {
        isLogin: false,
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
              credential.accessToken = accessToken
            }
        }
      }
      this.$store.dispatch('commitUpdateLoginCredential', {credential})
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
  .button {
    display: inline-block;
    margin-right: 10px;
    padding: 5px 15px;
    font-size: 1.1em;
  }
  .button:hover {
    cursor: pointer;
  }
</style>