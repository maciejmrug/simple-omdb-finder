<template>
  <div class="pure-g" v-if="!isMovieEmpty">
    <div class="pure-u-5-5">
      <ul>
        <li v-for="movie in movies">
          <div class="pure-g movie-item">
            <div class="pure-u-2-5">
              <img class="poster-image" :src="movie.posterUrl" v-if="movie.isPosterAvailable">
              <span id="no-poster-available" v-if="!movie.isPosterAvailable">Poster unavailable</span>
            </div>
            <div class="pure-u-3-5 movie-info">
              <p>{{ movie.title }}</p>
              <p>Type: {{ movie.type }}</p>
              <p>Year: {{ movie.year }}</p>
              <p><a target="_blank" :href="movie.imdbUrl">See on IMDB</a></p>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'SearchResults',
    computed: {
      movies() {
        return this.$store.state.movies
      },
      isMovieEmpty() {
        return Object.keys(this.movies).length === 0
      }
    }
  }
</script>

<style>
  .poster-image {
    max-width: 150px;
    max-height: 200px;
  }
  .movie-info {
    padding-top: 20px;
  }

  ul {
    list-style-type: none
  }

  ul div.movie-item {
    max-height: 200px;
    margin-bottom: 20px;
  }

  #movie-info p {
    margin-bottom: 10px;
  }
</style>
