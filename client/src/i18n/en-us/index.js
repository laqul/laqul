// This is just an example,
// so you can safely delete all default props below

export default {
  errors: {
    backend: {
      undefined: 'Ocurrio un error desconocido'
    },
    graphql: {
      undefined: 'Ocurrio un error desconocido'
    },
    firebase: {
      try_again: 'Ocurrio un error temporal, intente de nuevo por favor.'
    }
  },
  layouts: {
    authentication: {
      app_title: 'Laqul',
      close: 'Cerrar',
      terms_conditions: 'Terminos y Condiciones'
    },
    dashboard: {
      app_title: 'Laqul',
      notifications: 'Notificaciones',
      my_account: 'Mi Cuenta',
      exit: 'Salir',
      exit_all: 'Salir de todos los dispositivos',
      sections: 'Secciones',
      dashboard: 'Dashboard',
      dashboard_sub: 'Estadisticas',
      unblock: 'Desbloquear',
      activate: 'Activarlas',
      close: 'Cerrar',
      activate_notifications: 'Aun no activas las notificaciones',
      blocked_notifications: 'Tienes las notificaciones bloqueadas'
    },
    user: {
      avatar: 'Avatar',
      info: 'Informacion',
      password: 'Password'
    }
  },
  pages: {
    errors: {
      e404: {
        title: 'Esta pagina no existe',
        message: 'Ups esta pagina no existe...(404)',
        go_back: 'Regresar'
      }
    },
    authentication: {
      login: {
        title: 'Acceso'
      },
      email_verification: {
        title: 'Registro'
      },
      registration: {
        title: 'Registro'
      },
      forgot_password: {
        title: 'Restablecimiento de password'
      },
      reset_password: {
        title: 'Restablecimiento de password'
      },
      social_login: {
        title: 'Login Social',
        loading_text: 'Accediendo con tu red social...',
        social_auth: 'Accediendo con tu red social'
      }
    },
    dashboard: {
      home: {
        title: 'Dashboard Home'
      },
      user_avatar: {
        title: 'Elige una imagen para tu perfil'
      },
      user_info: {
        title: 'Informacion basica'
      },
      user_password: {
        title: 'Cambia tu password',
        change_password_unavailable: 'El cambio de password no esta disponible debido a que accediste con una plataforma social.'
      }
    }
  },
  components: {
    authentication: {
      email_verification: {
        title: 'Comienza tu registro',
        introduce_email: 'Escribe tu email',
        email: 'Email',
        invalid_email: 'Tu email no es correcto',
        verify_email: 'Verificar email',
        go_login: 'Ir a login',
        incorrect_input: 'Revisa tus datos',
        link_sent: 'Te enviamos un link para tu registro, si no lo encuentras revisa tu bandeja de correo no deseado o spam.'
      },
      forgot_password: {
        title: 'Recuperacion de acceso',
        introduce_email: 'Escribe tu email',
        email: 'Email',
        invalid_email: 'Tu email no es correcto',
        sendme_email: 'Enviar link de restablecimiento',
        go_login: 'Ir a login',
        incorrect_input: 'Revisa tu datos',
        link_sent: 'Te enviamos un link para recuperar tu acceso, si no lo encuentras revisa tu bandeja de correo no deseado o spam.'
      },
      login: {
        title: 'Acceso',
        introduce_email: 'Escribe tu email',
        invalid_email: 'Tu email no es correcto',
        email: 'Email',
        introduce_password: 'Escribe tu password',
        invalid_password: 'Formato de password incorrecto',
        password: 'Password',
        login: 'Acceder',
        register: 'Registrarme',
        forgot_password: 'Olvide mi password',
        incorrect_input: 'Revisa tus datos',
        invalid_credentials: 'Sus credenciales de acceso son incorrectas.',
        facebook: 'Accede con Facebook',
        google: 'Accede con Google'
      },
      registration: {
        title: 'Registro',
        invalid_name: 'Nombre no valido',
        name: 'Nombre',
        introduce_name: 'Introduce tu nombre',
        invalid_password: 'Formato de password incorrecto',
        password: 'Password',
        password_mismatch: 'El password no coincide',
        password_confirmation: 'Repite el password',
        terms_conditions: 'Acepto los terminos y condiciones',
        register: 'Registrarme',
        go_login: 'Ir a login',
        invalid_url: 'Su url de registro no es valida',
        incorrect_input: 'Revise sus datos',
        must_accept_terms: 'Debe aceptar los teminos y condiciones',
        successful_registration: 'Registro exitoso, accediendo...'
      },
      reset_password: {
        title: 'Restablecimiento de password',
        invalid_password: 'Formato de password incorrecto',
        password: 'Password',
        password_mismatch: 'El password no coincide',
        password_confirmation: 'Repita el password',
        reset: 'Restablecer',
        go_login: 'Ir a login',
        invalid_url: 'Su url de restablecimiento no es valida',
        incorrect_input: 'Revise sus datos',
        successful_reset: 'Su password fu restablecido, accediendo...'
      }
    },
    dashboard: {
      user_avatar: {
        select_image: 'Elige tu imagen',
        change_image: 'Otra imagen',
        save: 'Guardar',
        avatar_updated: 'Tu imagen de perfil fue actualizada.'
      },
      user_info: {
        title: 'Informacion de usuario',
        invalid_name: 'Nombre no valido',
        name: 'Nombre',
        update: 'Actualizar',
        incorrect_input: 'Revise sus datos por favor.',
        info_updated: 'Informacion actualizada'
      },
      user_password: {
        title: 'Cambio de password',
        current_password: 'Password actual',
        new_password: 'Nuevo password',
        password_confirmation: 'Repite el password',
        invalid_password: 'Formato de password incorrecto',
        password_mismatch: 'El password no coincide',
        change: 'Cambiar',
        incorrect_input: 'Revise sus datos por favor.',
        password_updated: 'Su password fue actualizado'
      }
    }
  }
}
