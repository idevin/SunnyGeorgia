import Api from './Api'

class FilterApi extends Api {
  getExcursionsParams (queryString) {
    return this.axios.get('/filter/get-excursions-params?' + queryString)
  }
  getFilteredExcursions (queryString) {
    return this.axios.get('/filter/excursions' + queryString)
  }

  getToursParams (queryString) {
    return this.axios.get('/filter/get-tours-params?' + queryString)
  }
  getFilteredTours (queryString) {
    return this.axios.get('/filter/tours' + queryString)
  }
}

export default new FilterApi()
