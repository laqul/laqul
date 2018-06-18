import store from '../store'
import config from '../config'
import firebase from 'firebase'
import axios from 'axios'
import { Loading } from 'quasar'
import { _LocalStorage } from '../boot/local-storage'
import router from '../router'
import errorHandler from '../error-handler'
import { apolloProvider } from '../boot/apollo-init'
import LOGOUT from '../graphql/mutations/logout.gql'

var messagingInstance = null

const deleteFcmToken = () => {
  if (!config.firebase.enabled || !config.firebase.fcm.enabled || store.state.session.cloudMessaging.notificationsBlocked) {
    return Promise.resolve(true)
  }
  messagingInstance = firebase.messaging()
  return messagingInstance.getToken()
    .then(currentToken => {
      if (!currentToken) {
        return Promise.resolve(true)
      }
      return messagingInstance.deleteToken(currentToken)
    })
}

const firebaseLogout = () => {
  if (config.firebase.enabled && firebase.auth().currentUser) {
    return firebase.auth().signOut()
  }
  return Promise.resolve(true)
}

const apiLogout = (logoutType) => {
  return apolloProvider.defaultClient.mutate({
    mutation: LOGOUT,
    variables: {
      type: logoutType
    }})
}

const backendLogout = () => {
  return axios.post('/backend/logout')
}

export const clear = (all = false) => {
  if (all) {
    _LocalStorage.clear()
  } else {
    _LocalStorage.remove(config.session.tokenName)
  }
  apolloProvider.defaultClient.cache.reset()
  store.commit('session/clear')
  router.push('/')
  return Promise.resolve(true)
}

export const onFail = () => {
  clear(true)
  deleteFcmToken()
  firebaseLogout()
  backendLogout()
  return Promise.resolve(true)
}

export default (logoutType) => {
  Loading.show()
  deleteFcmToken()
    .then(success => firebaseLogout())
    .then(success => apiLogout(logoutType))
    .then(success => backendLogout())
    .then(success => clear())
    .then(success => {
      Loading.hide()
    }).catch(error => {
      Loading.hide()
      errorHandler(this, error)
    })
}
