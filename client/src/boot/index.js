import consoleOutput from './console-output'
import localStorageCheck from './local-storage'
import { axiosInterceptors } from '../interceptors/axios'
import xsrf from './xsrf'
import firebaseInit from './firebase-init'
import apolloInit from './apollo-init'
import appSetup from './app-setup'
import session from './session'

export default () => {
  return consoleOutput()
    .then(success => localStorageCheck())
    .then(success => axiosInterceptors())
    .then(success => xsrf())
    .then(xsrfResponse => apolloInit())
    .then(success => appSetup())
    .then(success => session())
    .then(success => firebaseInit())
}
