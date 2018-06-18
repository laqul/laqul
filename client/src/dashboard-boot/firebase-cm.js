import store from '../store'
import config from '../config'
import firebase from 'firebase'
import errorHandler from '../error-handler'
import { Notify } from 'quasar'
import { apolloProvider } from '../boot/apollo-init'
import SAVE_FCM_TOKEN from '../graphql/mutations/saveFcmToken.gql'

var messagingInstance = null
var initialized = false

const sendTokenToServer = (token, status) => {
  return apolloProvider.defaultClient.mutate({
    mutation: SAVE_FCM_TOKEN,
    variables: {
      token
    }})
}

const processMessagingToken = (status) => {
  return messagingInstance.getToken()
    .then(currentToken => {
      if (currentToken) {
        return sendTokenToServer(currentToken, status)
      }
      store.commit('session/fcmNotificationPromptShowed', false)
      return Promise.resolve(null)
    })
}

export const askForPermission = () => {
  messagingInstance.requestPermission()
    .then(() => {
      store.commit('session/fcmNotificationPromptShowed', true)
      return processMessagingToken('new')
    }).catch(error => errorHandler(this, error))
}

export default () => {
  if (!config.firebase.enabled || !config.firebase.fcm.enabled) {
    return Promise.resolve(true)
  }
  if (!initialized) {
    initialized = true
    messagingInstance = firebase.messaging()
    messagingInstance.onTokenRefresh(() => {
      processMessagingToken('renewed').catch(error => errorHandler(this, error))
    })
    messagingInstance.onMessage(response => {
      let payload = JSON.parse(response.data.payload)
      if (response.notification) {
        Notify.create({
          message: response.notification.title,
          detail: response.notification.body,
          color: 'dark',
          position: 'bottom-right'
        })
      }
      store.commit('session/fcmMessage', payload)
      if (payload.sincronize) {
        store.dispatch('session/getUserNotifications')
      }
    })
  }
  return processMessagingToken('current')
}
