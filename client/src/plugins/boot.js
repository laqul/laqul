// import something here
import boot from '../boot'
import errorHandler from '../error-handler'
import { apolloProvider } from '../boot/apollo-init'
// leave the export, even if you don't use it
export default ({ app, router, Vue }) => {
  // something to do
  boot()
    .then(success => {
      app.provide = apolloProvider.provide()
      new Vue(app) // eslint-disable-line no-new
    }).catch(error => errorHandler(this, error))
}
