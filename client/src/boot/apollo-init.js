import Vue from 'vue'
import { ApolloClient } from 'apollo-client'
import { HttpLink } from 'apollo-link-http'
import { ApolloLink } from 'apollo-link'
import { InMemoryCache } from 'apollo-cache-inmemory'
import VueApollo from 'vue-apollo'
import config from '../config'
import { middleware, afterware } from '../interceptors/apollo'

const httpLink = new HttpLink({
  // You should use an absolute URL here
  uri: config.apiGraphQL
})

const link = ApolloLink.from([middleware, afterware, httpLink])

// Create the apollo client
const apolloClient = new ApolloClient({
  link,
  cache: new InMemoryCache(),
  connectToDevTools: true
})

export const apolloProvider = new VueApollo({
  defaultClient: apolloClient
})

export default () => {
  Vue.use(VueApollo)
  return Promise.resolve(true)
}
