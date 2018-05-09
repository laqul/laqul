// import something here
import errorHandler from '../error-handler'
// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  // something to do
  Vue.prototype.$errorHandler = errorHandler
}
