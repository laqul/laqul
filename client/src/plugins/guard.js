// import something here

// leave the export, even if you don't use it
export default ({ app, router, store, Vue }) => {
  // something to do
  router.beforeEach((to, from, next) => {
    var accessToken = store.state.session.userSession.accessToken
    // ESTANDO LOGEADO
    if (accessToken) {
      // SE PERMITE IR DE AREA PUBLICA A PRIVADA
      if (!from.matched.some(record => record.meta.requiresAuth) && to.matched.some(record => record.meta.requiresAuth)) {
        next()
      }
      // SE PERMITE IR DE UNA AREA PRIVADA A OTRA PRIVADA
      if (from.matched.some(record => record.meta.requiresAuth) && to.matched.some(record => record.meta.requiresAuth)) {
        next()
      }
      // NO SE PERMITE IR A UN AREA PUBLICA DESDE UN AREA PRIVADA
      if (from.matched.some(record => record.meta.requiresAuth) && !to.matched.some(record => record.meta.requiresAuth)) {
        next(false)
      }
      // SE REDIRIJE AL PANEL
      if (!from.matched.some(record => record.meta.requiresAuth) && !to.matched.some(record => record.meta.requiresAuth)) {
        next('/Panel')
      }
      // NO ESTA LOGEADO
    } else {
      // SE PERMITE IR DE UNA AREA PUBLICA A OTRA PUBLICA
      if (!from.matched.some(record => record.meta.requiresAuth) && !to.matched.some(record => record.meta.requiresAuth)) {
        next()
      }
      // SE PERMITE IR DE UNA AREA PRIVADA A UNA PUBLICA (LOGOUT)
      if (from.matched.some(record => record.meta.requiresAuth) && !to.matched.some(record => record.meta.requiresAuth)) {
        next()
      }
      // NO SE PERMITE IR DE UNA AREA PUBLICA A UNA PRIVADA
      if (!from.matched.some(record => record.meta.requiresAuth) && to.matched.some(record => record.meta.requiresAuth)) {
        // REDIRIGIR A LOGIN
        next('/')
      }
    }
  })
}
