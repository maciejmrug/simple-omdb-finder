<template>
  <div id="app">
    <div class="pure-g">
      <div class="pure-u-1-5"></div>
      <div class="pure-u-3-5">
        <h3>Simple OMDB Finder (<a target="_blank" href="https://www.omdbapi.com/">www.omdbapi.com</a>)</h3>
        <search-input></search-input>
        <search-results></search-results>
        <error></error>
      </div>
      <div class="pure-u-1-5"></div>
    </div>
  </div>
</template>

<script>
import SearchInput from './components/SearchInput.vue'
import SearchResults from './components/SearchResults.vue'
import Error from './components/Error.vue'

export default {
  name: 'app',
  data () {
    return {
    }
  },
  components: {
    SearchInput,
    SearchResults,
    Error
  }
}
</script>
