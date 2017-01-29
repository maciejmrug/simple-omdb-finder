<template>
  <div>
    <div class="pure-g" v-if="notFoundMessage">
      <div class="pure-u-1-5"></div>
      <div class="pure-u-3-5 center">{{ notFoundMessage }}</div>
      <div class="pure-u-1-5"></div>
    </div>
    <div class="pure-g" v-if="searchErrorMessage">
      <div class="pure-u-1-5"></div>
      <div class="pure-u-3-5 center">{{ searchErrorMessage }}</div>
      <div class="pure-u-1-5"></div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'Error',
    computed: {
      notFoundMessage() {
        return this.$store.state.notFoundMessage
      },
      searchErrorMessage() {
        return this.$store.state.searchErrorMessage
      }
    }
  }
</script>
<style>
  .center {
    text-align: center;
  }
</style>