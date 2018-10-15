<template>
  <transition name="fade" mode="out-in">
    <div class="loader-container" v-if="isAppLoading">
      <div class="vue-simple-spinner-wrap is-fullheight" v-if="isAppLoading">
        <vue-simple-spinner size="75" :line-size=6 line-fg-color="#2d2b4a"></vue-simple-spinner>
      </div>
    </div>
  </transition>
</template>

<script>
  import VueSimpleSpinner from 'vue-simple-spinner';
  export default {
    components:{ VueSimpleSpinner },
    props:['isAppLoading']
  }
</script>

<style lang="scss" scoped>
  .loader-container{
    position: absolute;
    top:0;
    bottom:0;
    left:0;
    right:0;
    z-index: 10;
    background-image:  linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%);
  }
</style>