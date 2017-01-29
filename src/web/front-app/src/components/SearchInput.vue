<template>
  <div class="pure-form">
    <fieldset>
      <div class="pure-g">
        <div class="pure-u-3-5">
          <input id="search-input"
               v-model="query"
               placeholder="Type movie title..."
               @keyup.enter="search">
        </div>
        <div class="pure-u-2-5">
          <button class="pure-button pure-button-primary"
              id="search-button"
              @click="search">
            Search!
          </button>
        </div>
      </div>
    </fieldset>
  </div>
</template>

<script>
  export default {
    name: 'SearchInput',
    data () {
      return {
        query: '',
        debounceTimeout: 500,
        timer: null
      }
    },
    methods: {
      search() {
        clearTimeout(this.timer)
        this.timer = setTimeout(() => {
          let trimmedQuery = this.query.trim()
          if (trimmedQuery !== '') {
            this.$store.dispatch('search', trimmedQuery)
          }
        }, this.debounceTimeout)
      }
    }
  }
</script>

<style>
  #search-input {
    width: 100%
  }
  #search-button {
    margin-left: 10%;
    width: 90%
  }
</style>
