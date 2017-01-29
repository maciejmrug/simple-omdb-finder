import Vue from 'vue'
import VueResource from 'vue-resource'
import Vuex from 'vuex'
import App from './App.vue'
import Purecss from 'purecss'
import store from './store.js'

Vue.use(VueResource)

new Vue({
  el: '#app',
  store,
  render: h => h(App)
})
