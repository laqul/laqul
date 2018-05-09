import { LocalStorage } from 'quasar'
import { onFail } from '../session/logout'
import appSetup from './app-setup'
import config from '../config'

var authorized = false

export default () => {
  if (config.localStorage.enableListener) {
    window.addEventListener('storage', (e) => {
      if (!authorized) {
        console.warn('Unauthorized local storage change')
        switch (config.localStorage.unauthChange) {
          case 'block':
            if (e.key === 'null' || e.key === null) {
              reload()
            } else {
              _LocalStorage.setNative(e.key, e.oldValue)
            }
            break
          case 'clear':
            reload()
            break
          default:
            reload()
            break
        }
      }
    }, false)
  }
  return Promise.resolve(true)
}

const reload = () => {
  onFail().then(success => appSetup())
}

export const _LocalStorage = {
  setNative (key, value) {
    authorized = true
    localStorage.setItem(key, value)
    authorized = false
  },
  set (key, value) {
    authorized = true
    LocalStorage.set(key, value)
    authorized = false
  },
  remove (key) {
    authorized = true
    LocalStorage.remove(key)
    authorized = false
  },
  clear () {
    authorized = true
    LocalStorage.clear()
    authorized = false
  },
  get (key) {
    return LocalStorage.get.item(key)
  }
}
