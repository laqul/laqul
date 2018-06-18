// Los parametros que aqui se indican seran copiados a localstorage y podran ser modificados
// por el usuario, los parametros incluidos aqui deben estar relacionados con la configuracion de
// la interfaz de usuario, de esta manera las opciones elegidas por el usuario se conservan
// aun despues de cerrar sesion
import config from '../../config'

export default {
  setup: {
    language: config.language.default,
    showTerms: false
  }
}
