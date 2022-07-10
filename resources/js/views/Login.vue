<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-login-container">
      <div class="login-container">
        <p class="login-header-text">管理者画面ログイン</p>
        <table>
          <tr>
            <th>UserName</th>
            <td>
              <input class="input-box" type="text" v-on:blur="trimEmail" v-model="email" maxlength="255">
              <div id="email-error" class="error-message red hidden">メールアドレスの形式で入力して下さい.</div>
            </td>
          </tr>
          <tr>
            <th>Password</th>
            <td>
              <input class="input-box" type="password" v-on:blur="trimPassword" v-model="password" maxlength="16">
              <div id="password-error" class="error-message red hidden">errorMessage</div>
            </td>
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
  methods: {
    async login() {
      if (!this.loginValidation()) {
        await this.apiCallLoginCredential(this.email, this.password)
        if (this.$store.getters['isLogin']) {
          this.$router.push('admin')
          this.$awn.success('ログインしました.')
          console.log('info:System login.')
        }
      }
    },
    loginValidation() {
      let isEmailError = false
      if (this.email.length === 0) {
        isEmailError = this.showErrorMessage('email-error', 'メールアドレスを入力して下さい.')
      }else{
        if (!this.email.match(/^[\w-_][\w-_.]+[\w-_]@[\w-_][\w-_.]*\.[\w-_.]*[\w-_]$/g)) {
          isEmailError = this.showErrorMessage('email-error', 'メールアドレスの形式で入力して下さい.')
        }else{
          isEmailError = this.hiddenErrorMessage('email-error')
        }
      }
      
      let isPasswordError = false
      if (this.password.length === 0) {
        isPasswordError = this.showErrorMessage('password-error', 'パスワードを入力して下さい.')
      }else{
        if (!this.password.match(/^[A-Za-z0-9]+$/g)) {
          isPasswordError = this.showErrorMessage('password-error', '半角英字・半角数字のみ入力可能です.')
        }else{
          isPasswordError = this.hiddenErrorMessage('password-error')
        }
      }
      return isEmailError || isPasswordError ? true : false
    },
    showErrorMessage(id, errorMessage) {
      document.getElementById(id).classList.contains('hidden') ? document.getElementById(id).classList.toggle('hidden') : ''
      document.getElementById(id).innerText = errorMessage
      return true
    },
    hiddenErrorMessage(id) {
      !document.getElementById(id).classList.contains('hidden') ? document.getElementById(id).classList.toggle('hidden') : ''
      return false
    },
    trimEmail() {
      this.email = this.email.trim()
    },
    trimPassword() {
      this.password = this.password.trim()
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
  .error-message {
    margin-top: 5px;
  }
  .hidden {
    display: none;
  }
  .red {
    color: red;
  }
</style>