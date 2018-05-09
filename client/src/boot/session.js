import config from '../config'
import { _LocalStorage } from '../boot/local-storage'
import store from '../store'

export default () => {
  let session = _LocalStorage.get(config.session.tokenName)
  if (session) {
    store.commit('session/setAccessToken', session)
  } else {
    store.commit('session/setAccessToken', null)
  }
  return Promise.resolve(true)
}
