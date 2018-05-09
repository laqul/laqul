import Backend from './backend'
import Firebase from './firebase'
import Graphql from './graphql'

export default (context, error) => {
  if (error.constructor.name === 'FirebaseError') {
    Firebase(error)
    return
  }
  if (error.response && error.response.data && error.response.data.backend) {
    Backend(error)
    return
  }
  if (error[0] && error[0].locations && error[0].validation) {
    Graphql(error)
    return
  }
  console.log('Error handler', error)
}
