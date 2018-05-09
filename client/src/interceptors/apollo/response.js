import errorHandler from '../../error-handler'

export const resNetError = (networkError) => {
  errorHandler(this, networkError)
}

export const resGQLError = (graphQLError) => {
  errorHandler(this, graphQLError)
}
