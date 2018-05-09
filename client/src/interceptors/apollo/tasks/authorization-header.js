import store from '../../../store'

export default (config) => {
  if (store.state.session.userSession.accessToken) {
    config.headers.Authorization = 'Bearer ' + store.state.session.userSession.accessToken.token
  }
  return Promise.resolve(config)
}
