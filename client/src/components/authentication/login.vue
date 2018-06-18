<template>
  <q-card flat style="background: rgba(254, 254, 254, 0.9) !important;" inline color="white" text-color="dark">
    <q-card-title>
      {{$t('components.authentication.login.title')}}
    </q-card-title>
    <q-card-main>
      <q-field class="q-mb-md" icon="email" :helper="$t('components.authentication.login.introduce_email')" :error="$v.loginForm.email.$error" :error-label="$t('components.authentication.login.invalid_email')">
        <q-input @keyup.enter="login" :float-label="$t('components.authentication.login.email')" v-model="loginForm.email" type="email" />
      </q-field>
      <q-field class="q-mb-md" icon="lock" :helper="$t('components.authentication.login.introduce_password')" :error="$v.loginForm.password.$error" :error-label="$t('components.authentication.login.invalid_password')">
        <q-input @keyup.enter="login" :float-label="$t('components.authentication.login.password')" v-model="loginForm.password" type="password" />
      </q-field>
      <q-btn color="primary" rounded :loading="loading" @click="login">{{$t('components.authentication.login.login')}}</q-btn>
    </q-card-main>
    <q-card-separator />
    <q-card-main class="flex flex-center">
      <q-btn v-if="$config.socialLogin.facebook" :loading="loading" class="q-mb-md q-mr-md" rounded icon="fab fa-facebook-f" size="sm" color="blue-10" text-color="white" @click="facebook" :label="$t('components.authentication.login.facebook')"/>
      <q-btn v-if="$config.socialLogin.google" :loading="loading" class="q-mb-md q-mr-md" rounded icon="fab fa-google" size="sm" color="deep-orange-14" text-color="white" @click="google" :label="$t('components.authentication.login.google')"/>
    </q-card-main>
    <q-card-separator />
    <q-card-actions>
      <q-btn flat @click="$router.push('/EmailVerification')">{{$t('components.authentication.login.register')}}</q-btn>
      <q-btn flat @click="$router.push('/ForgotPassword')">{{$t('components.authentication.login.forgot_password')}}</q-btn>
  </q-card-actions>
  </q-card>
</template>

<script>
import { required, email, minLength, maxLength } from 'vuelidate/lib/validators'
export default {
  data () {
    return {
      loading: false,
      loginForm: {
        email: '',
        password: ''
      }
    }
  },
  validations: {
    loginForm: {
      email: { required, email },
      password: { required, minLength: minLength(8), maxLength: maxLength(30) }
    }
  },
  methods: {
    valid () {
      this.$v.loginForm.$touch()
      if (this.$v.loginForm.$error) {
        this.$q.notify({ message: this.$t('components.authentication.login.incorrect_input'), position: 'center' })
        return false
      } else {
        this.$v.loginForm.$reset()
        return true
      }
    },
    login () {
      if (this.valid()) {
        this.loading = true
        this.$store.dispatch('session/passwordLogin', {
          username: this.loginForm.email,
          password: this.loginForm.password
        }).then(response => {
          this.loading = false
          this.$router.push('/Panel')
        }).catch(error => this.error(error))
      }
    },
    facebook () {
      this.loading = true
      this.$axios.get('/backend/loginFacebook')
        .then(response => this.redirect(response))
        .catch(error => this.error(error))
    },
    google () {
      this.loading = true
      this.$axios.get('/backend/loginGoogle')
        .then(response => this.redirect(response))
        .catch(error => this.error(error))
    },
    redirect (response) {
      this.loading = false
      window.location.href = response.data.redirect
    },
    error (error) {
      this.loading = false
      this.$errorHandler(this, error)
    }
  }
}
</script>
