import Api from './Api'

class AuthApi extends Api {
  checkEmail (data) {
    return this.axios.post('/auth/check-email', data)
  }
  checkUniqueEmail (data) {
    return this.axios.post('/auth/check-unique-email', data)
  }
}

export default new AuthApi()
