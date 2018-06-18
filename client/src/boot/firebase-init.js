import config from '../config'
import firebase from 'firebase'
import store from '../store'

const swCompatibility = () => {
  const isLocalhost = Boolean(window.location.hostname === 'localhost' ||
    // [::1] is the IPv6 localhost address.
    window.location.hostname === '[::1]' ||
    // 127.0.0.1/8 is considered localhost for IPv4.
    window.location.hostname.match(
      /^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/
    )
  )
  if ('serviceWorker' in navigator &&
        (window.location.protocol === 'https:' || isLocalhost)) {
    return true
  }
  return false
}

export default () => {
  if (config.firebase.enabled) {
    firebase.initializeApp(config.firebase.config)
    return authState()
      .then(success => serviceWorker())
  } else {
    return Promise.resolve(true)
  }
}

const authState = () => {
  return new Promise((resolve) => {
    firebase.auth().onAuthStateChanged(user => {
      if (user && !store.state.session.userSession.accessToken) {
        firebase.auth().signOut()
      }
      return resolve(true)
    })
  })
}

const serviceWorker = () => {
  if (config.firebase.enabled && config.firebase.fcm.enabled && swCompatibility()) {
    return navigator.serviceWorker.register('statics/firebase-messaging-sw.js')
      .then(registration => {
        firebase.messaging().useServiceWorker(registration)
        return Promise.resolve(true)
      })
  } else {
    return Promise.resolve(true)
  }
}
