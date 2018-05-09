// import something here
import { _LocalStorage } from '../boot/local-storage'
// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  // something to do
  Vue.prototype.$_localStorage = _LocalStorage
}
