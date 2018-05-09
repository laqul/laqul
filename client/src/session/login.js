import axios from 'axios'
import { setSession } from './common'

export const _passwordLogin = (username, password) => {
  return axios.post('/backend/login', {username, password})
    .then(response => setSession(response, false))
}

export const _socialLogin = (code, platform, timezone) => {
  return axios.post('/backend/socialLogin', {code, platform, timezone})
    .then(response => setSession(response, true))
}
