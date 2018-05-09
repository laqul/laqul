import { setContext } from 'apollo-link-context'
import { onError } from 'apollo-link-error'
import { req } from './request'
import { resNetError, resGQLError } from './response'

export const middleware = setContext(operation => req(operation))

export const afterware = onError(({ graphQLErrors, networkError }) => {
  if (graphQLErrors) {
    resGQLError(graphQLErrors)
  }
  if (networkError) {
    resNetError(networkError)
  }
})
