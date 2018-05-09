var finishCurrent = true
var queueCount = 0
var first = true

const waitCurrent = () => {
  queueCount++
  return new Promise((resolve) => {
    let inter = setInterval(() => {
      if (finishCurrent) {
        clearInterval(inter)
        return resolve(true)
      }
    }, 500)
  })
}

const queue = () => {
  finishCurrent = false
  return new Promise((resolve) => {
    if (first) {
      first = false
      return dispatch(resolve)
    }
    setTimeout(() => {
      return dispatch(resolve)
    }, 1000)
  })
}

const dispatch = (resolve) => {
  finishCurrent = true
  queueCount--
  if (!first && queueCount === 0) {
    first = true
  }
  return resolve(true)
}

export default () => {
  return waitCurrent()
    .then(success => queue())
}
