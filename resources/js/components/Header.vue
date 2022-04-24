<template>
  <div class="header">
    <img class="header-img" :src="'/images/header_img.jpg'" alt="">
  </div>
</template>

<script>
export default {

}
</script>

<style>
  .header {
    width: 100%;
    background: black;
    display: flex;
    justify-content: center;
  }
  .header-img{
    display: inline-block;
    width: 300px;
    margin: 0;
    padding: 20px 0px;
  }
  @media screen and (max-width: 480px) {
    .header-text {
      font-size: 1.65em;
    }
    .header-img {
      width: 200px;
    }
  }
</style>