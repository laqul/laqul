export const res = (response) => {
  return Promise.resolve(response)
}

export const resError = (error) => {
  return Promise.reject(error)
}
