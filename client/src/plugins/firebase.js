// import something here
import firebase from 'firebase'
// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  // something to do
  Vue.prototype.$firebase = firebase
}
