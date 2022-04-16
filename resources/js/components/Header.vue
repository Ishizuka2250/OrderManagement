<template>
  <div class="header">
    <h1 class="header-text">CUT SHOP FREESTYLE</h1>
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
  .header-text{
    display: inline-block;
    color: gold;
    font-size: 1.8em;
    margin: 0;
    padding: 20px 0px;
  }
  @media screen and (max-width: 480px) {
    .header-text {
      font-size: 1.65em;
    }
  }
</style>