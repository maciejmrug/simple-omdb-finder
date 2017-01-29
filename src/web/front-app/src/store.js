import ApiClient from './api/ApiClient.js';
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const state = {
  query: '',
  movies: {},
  notFoundMessage: '',
  searchErrorMessage: ''
}

const mutations = {
  setMovies(state, payload) {
    state.movies = payload
  },
  clearMovies(state) {
    state.movies = {}
  },
  noMoviesFound(state, notFoundMessage) {
    state.notFoundMessage = notFoundMessage
  },
  searchError(state, searchErrorMessage) {
    state.searchErrorMessage = searchErrorMessage
  },
  clearErrors() {
    state.searchErrorMessage = ''
    state.notFoundMessage = ''
  }
}

const getters = {}

const actions = {
  search: ({ commit }, query) => {
    commit('clearErrors')
    commit('clearMovies')
    ApiClient.search(query,
      (moviesPayload) => {
        commit('setMovies', moviesPayload);
      },
      (notFoundMessage) => {
        commit('noMoviesFound', notFoundMessage)
      },
      (errorMessage) => {
        commit('searchError', errorMessage)
      }
    )
  }
}

export default new Vuex.Store({
  state,
  getters,
  actions,
  mutations
})