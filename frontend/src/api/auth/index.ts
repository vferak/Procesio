import Api from '@/api'

const AuthRepository = {
  authenticate (username: string, password: string) {
    return Api.post('/login', { username: username, password: password })
  }
}

export default AuthRepository
