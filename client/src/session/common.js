import store from '../store'
import config from '../config'
import firebase from 'firebase'
import { _LocalStorage } from '../boot/local-storage'

const setObjectToken = (response) => {
  var now = new Date().getTime() / 1000
  var token = {
    token: response.data.access_token,
    expire_at: response.data.expires_in + now
  }
  if (response.data.firebase_access_token) {
    token.firebase_token = response.data.firebase_access_token
  }
  return token
}

const firebaseLogin = (token) => {
  if (token.firebase_token && config.firebase.enabled) {
    return firebase.auth().signInWithCustomToken(token.firebase_token)
      .then(user => Promise.resolve({firebaseUser: user, token}))
  } else {
    return Promise.resolve({firebaseUser: null, token})
  }
}

export const setSession = (response, social) => {
  let token = setObjectToken(response)
  token.social = social
  store.commit('session/setAccessToken', token)
  _LocalStorage.set(config.session.tokenName, token)
  return firebaseLogin(token)
}
