<template>
  <div class="container">
    <AppHeader></AppHeader>
    <div class="outer-login-container">
      <div class="login-container">
        <p class="login-header-text">管理者画面ログイン</p>
        <table>
          <tr>
            <th>UserName</th>
            <td><input class="input-box" type="text"></td>
          </tr>
          <tr>
            <th>Password</th>
            <td><input class="input-box" type="password" name="" id=""></td>
          </tr>
        </table>
        <div class="login-button-row">
          <button class="login-button">Login</button>
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