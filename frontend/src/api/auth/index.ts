import Api from '@/api'

const AuthRepository = {
  authenticate (email: string, password: string) {
    return Api.post('/login', { email: email, password: password })
  }
}

export default AuthRepository
