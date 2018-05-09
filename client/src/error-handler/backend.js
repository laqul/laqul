import { i18n } from '../plugins/i18n'
import { Notify } from 'quasar'
export default (error) => {
  let message = i18n.t('errors.backend.undefined')
  if (error.response.data.error && error.response.data.message) {
    message = error.response.data.message
  }

  if (error.response.data.errors) {
    let errors = Object.keys(error.response.data.errors)
    message = error.response.data.errors[errors[0]][0]
  }

  Notify.create({
    message,
    position: 'center'
  })

  if (message === i18n.t('errors.backend.undefined')) {
    console.log(error.response)
  }
}
