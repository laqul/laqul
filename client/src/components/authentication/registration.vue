<template>
  <q-card flat style="background: rgba(254, 254, 254, 0.9) !important;" inline color="white" text-color="dark">
    <q-card-title>
      {{$t('components.authentication.registration.title')}}
    </q-card-title>
    <q-card-main>
      <q-alert icon="account_circle" type="info" class="q-mb-sm">{{ params.email }}</q-alert>
      <q-field class="q-mb-md q-mt-md" icon="person" :helper="$t('components.authentication.registration.introduce_name')" :error="$v.registerForm.name.$error" :error-label="$t('components.authentication.registration.invalid_name')">
        <q-input @keyup.enter="register" :float-label="$t('components.authentication.registration.name')" v-model="registerForm.name" type="text" />
      </q-field>
      <q-field class="q-mb-md" icon="lock" :error="$v.registerForm.password.$error" :error-label="$t('components.authentication.registration.invalid_password')">
        <q-input @keyup.enter="register" :float-label="$t('components.authentication.registration.password')" v-model="registerForm.password" type="password" />
      </q-field>
      <q-field class="q-mb-md" inset="icon" :error="$v.registerForm.repeat_password.$error" :error-label="$t('components.authentication.registration.password_mismatch')">
        <q-input @keyup.enter="register" :float-label="$t('components.authentication.registration.password_confirmation')" v-model="registerForm.repeat_password" type="password" />
      </q-field>
      <q-checkbox v-model="registerForm.policies" />
      <q-btn color="primary" flat @click="$store.commit('app/showTerms', true)">{{$t('components.authentication.registration.terms_conditions')}}</q-btn>
      <q-btn class="q-mt-md" color="primary" rounded :loading="loading" @click="register">{{$t('components.authentication.registration.register')}}</q-btn>
    </q-card-main>
    <q-card-separator />
    <q-card-actions>
      <q-btn flat @click="$router.push('/')">{{$t('components.authentication.registration.go_login')}}</q-btn>
    </q-card-actions>
  </q-card>
</template>

<script>
import {
  required,
  email,
  minLength,
  maxLength,
  sameAs
} from 'vuelidate/lib/validators'
export default {
  data () {
    return {
      loading: false,
      params: {
        code: this.$route.params.code,
        email: ''
      },
      registerForm: {
        name: '',
        password: '',
        repeat_password: '',
        policies: false
      }
    }
  },
  validations: {
    registerForm: {
      name: { required, minLength: minLength(4), maxLength: maxLength(30) },
      password: { required, minLength: minLength(8), maxLength: maxLength(30) },
      repeat_password: { required, sameAsPassword: sameAs('password') },
      policies: { required }
    },
    params: {
      code: { required, minLength: minLength(100), maxLength: maxLength(100) },
      email: { required, email }
    }
  },
  created () {
    this.params.email = this.$_localStorage.get('email-verification')
    this.validParams()
  },
  methods: {
    validParams () {
      this.$v.params.$touch()
      if (this.$v.params.$error) {
        this.$router.push('/')
      }
    },
    valid () {
      this.$v.params.$touch()
      this.$v.registerForm.$touch()
      if (this.$v.params.$error) {
        this.$q.notify({ message: this.$t('components.authentication.registration.invalid_url'), position: 'center' })
        return false
      }
      if (this.$v.registerForm.name.$error || this.$v.registerForm.password.$error || this.$v.registerForm.repeat_password.$error) {
        this.$q.notify({ message: this.$t('components.authentication.registration.incorrect_input'), position: 'center' })
        return false
      }
      if (this.$v.registerForm.policies.$error) {
        this.$q.notify({ message: this.$t('components.authentication.registration.must_accept_terms'), position: 'center' })
        return false
      }
      this.$v.registerForm.$reset()
      return true
    },
    register () {
      if (this.valid()) {
        this.loading = true
        this.$axios
          .post('/backend/registration', {
            code: this.params.code,
            name: this.registerForm.name,
            password: this.registerForm.password,
            password_confirmation: this.registerForm.repeat_password,
            timezone: this.$moment.tz.guess()
          })
          .then(response => this.success())
          .catch(error => this.error(error))
      }
    },
    success () {
      this.$_localStorage.remove('email-verification')
      this.$q.notify({message: this.$t('components.authentication.registration.successful_registration'), type: 'positive', position: 'center'})
      this.login()
    },
    login () {
      this.$store.dispatch('session/passwordLogin', {
        username: this.params.email,
        password: this.registerForm.password
      }).then(response => {
        this.loading = false
        this.$router.push('/Panel')
      }).catch(error => this.error(error))
    },
    error (error) {
      this.loading = false
      this.$errorHandler(this, error)
    }
  }
}
</script>
