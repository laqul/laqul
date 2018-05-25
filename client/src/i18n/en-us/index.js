export default {
  errors: {
    backend: {
      undefined: 'An unknown backend error occurred'
    },
    graphql: {
      undefined: 'An unknown graphql error occurred'
    },
    firebase: {
      try_again: 'An unknown firebase error occurred'
    }
  },
  layouts: {
    authentication: {
      app_title: 'Laqul',
      close: 'Close',
      terms_conditions: 'Terms and Conditions'
    },
    dashboard: {
      app_title: 'Laqul',
      notifications: 'Notifications',
      my_account: 'My Account',
      exit: 'Exit',
      exit_all: 'Exit All',
      sections: 'Sections',
      dashboard: 'Dashboard',
      dashboard_sub: 'Statistics',
      unblock: 'Unblock',
      activate: 'Activate',
      close: 'Close',
      activate_notifications: 'Activate Notifications',
      blocked_notifications: 'Block Notifications'
    },
    user: {
      avatar: 'Avatar',
      info: 'Information',
      password: 'Password'
    }
  },
  pages: {
    errors: {
      e404: {
        title: 'This page doesn\'t exist',
        message: 'Opps this page doesn\'t exist...(404)',
        go_back: 'Go Back'
      }
    },
    authentication: {
      login: {
        title: 'Access'
      },
      email_verification: {
        title: 'Register'
      },
      registration: {
        title: 'Register'
      },
      forgot_password: {
        title: 'Reset your password'
      },
      reset_password: {
        title: 'Reset your password'
      },
      social_login: {
        title: 'Login Social',
        loading_text: 'Loading...',
        social_auth: 'Accessing your social network'
      }
    },
    dashboard: {
      home: {
        title: 'Dashboard Home'
      },
      user_avatar: {
        title: 'Choose an image for your profile'
      },
      user_info: {
        title: 'Basic Information'
      },
      user_password: {
        title: 'Change your password',
        change_password_unavailable: 'You can\t change your password'
      }
    }
  },
  components: {
    authentication: {
      email_verification: {
        title: 'Begin your registration',
        introduce_email: 'Enter your email',
        email: 'Email',
        invalid_email: 'Your email is invalid',
        verify_email: 'Verify your email',
        go_login: 'Back to Login',
        incorrect_input: 'Incorrect input.',
        link_sent: 'We sent a link to your mailbox.  If you can not find it check your junk mail or spam.'
      },
      forgot_password: {
        title: 'Recover your account',
        introduce_email: 'Enter your email',
        email: 'Email',
        invalid_email: 'Your email is not correct',
        sendme_email: 'Reset your account',
        go_login: 'Back to Login',
        incorrect_input: 'Incorrect Input',
        link_sent: 'We sent a link to your mailbox. if you can not find it check your junk mail or spam.'
      },
      login: {
        title: 'Access',
        introduce_email: 'Enter your email',
        invalid_email: 'This email is invalid',
        email: 'Email',
        introduce_password: 'Enter your password',
        invalid_password: 'This password is invalid',
        password: 'Password',
        login: 'Login',
        register: 'Register',
        forgot_password: 'Forgot Password',
        incorrect_input: 'Your input is incorrect',
        invalid_credentials: 'Your credentials are invalid',
        facebook: 'Login with Facebook',
        google: 'Login with Google'
      },
      registration: {
        title: 'Register',
        invalid_name: 'Invalid Name',
        name: 'Name',
        introduce_name: 'Screen name',
        invalid_password: 'The password format is incorrect',
        password: 'Password',
        password_mismatch: 'Your password is mismatched',
        password_confirmation: 'Confirm your password',
        terms_conditions: 'Accept terms and conditions',
        register: 'Register',
        go_login: 'Back to Login',
        invalid_url: 'This url is invalid',
        incorrect_input: 'Incorrect input',
        must_accept_terms: 'You must accept terms and conditions',
        successful_registration: 'You have successfully registered'
      },
      reset_password: {
        title: 'Reset your password',
        invalid_password: 'Password format invalid',
        password: 'Password',
        password_mismatch: 'Password mismatch',
        password_confirmation: 'Confirm your password',
        reset: 'Reset',
        go_login: 'Back to Login',
        invalid_url: 'This url is invalid',
        incorrect_input: 'Incorrect input',
        successful_reset: 'Your password has successfully been reset'
      }
    },
    dashboard: {
      user_avatar: {
        select_image: 'Choose your image',
        change_image: 'Change Image',
        save: 'Save',
        avatar_updated: 'Your avatar has been updated.'
      },
      user_info: {
        title: 'User information',
        invalid_name: 'Invalid name',
        name: 'Name',
        update: 'Update',
        incorrect_input: 'Incorrect input.',
        info_updated: 'Your information has been updated'
      },
      user_password: {
        title: 'Change your password',
        current_password: 'Current Password',
        new_password: 'New Password',
        password_confirmation: 'Password Confirmation',
        invalid_password: 'Invalid Password',
        password_mismatch: 'Password Mismatch',
        change: 'Change',
        incorrect_input: 'Incorrect input.',
        password_updated: 'Password updated'
      }
    }
  }
}
