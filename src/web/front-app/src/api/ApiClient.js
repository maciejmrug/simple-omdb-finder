import Vue from 'vue'

const baseApiUrl = OMDBFinderDataLayer.finderEndpointUrl;

export default {
  search(query, cbSuccess, cbNotFound, cbError) {
    Vue.http.get(baseApiUrl, {params: {title : query}}).then((response) => {
      cbSuccess(response.data)
    }, (response) => {
      if (response.status == 404) {
        cbNotFound(response.data.notFound)
        return;
      }
      if (response.data !== null && response.data.hasOwnProperty('error')) {
        cbError(response.data.error)
        return;
      }
      cbError('An unknown server error has occurred, we apologise for inconvenience.')
    })
  }
}