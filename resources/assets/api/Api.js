import axios from 'axios'

class Api {
  constructor () {
    this.axios = axios.create({
      baseURL: '/api',
      headers: {
        common: {
          'X-App-Locale': window.Laravel.locale || 'ru'
        }
      }
    })
  }
}

export default Api
