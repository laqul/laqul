import store from '../store'
import Quasar from 'quasar'
import { _LocalStorage } from '../boot/local-storage'
import { i18n } from '../plugins/i18n'

export default () => {
  let setup = _LocalStorage.get('setup')
  if (setup) {
    store.commit('app/setup', setup)
  } else {
    setup = store.state.app.setup
    _LocalStorage.set('setup', setup)
  }
  return language(setup)
}

const language = (setup) => {
  i18n.locale = setup.language
  import(`quasar-framework/i18n/${setup.language}`).then(lang => {
    Quasar.i18n.set(lang.default)
  })
  return Promise.resolve(true)
}
