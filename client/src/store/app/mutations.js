import { _LocalStorage } from '../../boot/local-storage'
import Quasar from 'quasar'
import { i18n } from '../../plugins/i18n'

export const setLanguage = (state, payload) => {
  let setup = _LocalStorage.get('setup')
  setup.language = payload
  state.setup.language = payload
  _LocalStorage.set('setup', setup)
  import(`quasar-framework/i18n/${payload}`).then(lang => {
    Quasar.i18n.set(lang.default)
  })
  i18n.locale = payload
}

export const showTerms = (state, payload) => {
  state.setup.showTerms = payload
}

export const setup = (state, payload) => {
  state.setup = payload
}
