import { i18n } from '../plugins/i18n'
import { Notify } from 'quasar'
export default (error) => {
  let message = i18n.t('errors.graphql.undefined')

  if (error[0].validation) {
    let errors = Object.keys(error[0].validation)
    message = error[0].validation[errors[0]][0]
  }

  Notify.create({
    message,
    position: 'center'
  })

  if (message === i18n.t('errors.graphql.undefined')) {
    console.log(error.response)
  }
}
