import config from '../config'

export default () => {
  if (!config.consoleOutput) {
    if (!window.console) window.console = {}
    var methods = ['log', 'debug', 'warn', 'info']
    for (var i = 0; i < methods.length; i++) {
      console[methods[i]] = function () {}
    }
  }
  return Promise.resolve(true)
}
