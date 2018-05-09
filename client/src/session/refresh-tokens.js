import store from '../store'
import _config from '../config'
import axios from 'axios'
import { setSession } from './common'
import { onFail } from './logout'

var refreshing = false

const waitForRefresh = () => {
  return new Promise((resolve) => {
    if (!refreshing) {
      return resolve(true)
    }
    let check = setInterval(() => {
      if (!refreshing) {
        clearInterval(check)
        return resolve(true)
      }
    }, 500)
  })
}

const refreshToken = () => {
  let social = store.state.session.userSession.accessToken.social
  refreshing = true
  return axios.post('/backend/refreshTokens')
    .then(response => setSession(response, social))
    .then(login => {
      refreshing = false
      return Promise.resolve(login)
    }).catch(error => {
      refreshing = false
      onFail()
      return Promise.reject(error)
    })
}

export const refreshTokenBefore = () => {
  return waitForRefresh().then(success => {
    let now = (new Date().getTime() / 1000) + _config.session.refreshTokenMargin
    if (store.state.session.userSession.accessToken && store.state.session.userSession.accessToken.expire_at <= now) {
      return refreshToken()
    } else {
      return Promise.resolve(true)
    }
  })
}
