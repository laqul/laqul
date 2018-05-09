<template>
  <q-card flat style="background: rgba(254, 254, 254, 0.9) !important;" inline color="white" text-color="dark">
      <q-card-title>
        {{$t('components.authentication.reset_password.title')}}
      </q-card-title>
      <q-card-main>
        <q-alert icon="account_circle" type="info" class="q-mb-sm">{{ params.email }}</q-alert>
        <q-field class="q-mb-md q-mt-md" icon="lock" :error="$v.resetForm.password.$error" :error-label="$t('components.authentication.reset_password.invalid_password')">
          <q-input @keyup.enter="reset" :float-label="$t('components.authentication.reset_password.password')" v-model="resetForm.password" type="password" />
        </q-field>
        <q-field class="q-mb-md" inset="icon" :error="$v.resetForm.repeat_password.$error" :error-label="$t('components.authentication.reset_password.password_mismatch')">
          <q-input @keyup.enter="reset" :float-label="$t('components.authentication.reset_password.password_confirmation')" v-model="resetForm.repeat_password" type="password" />
        </q-field>
        <q-btn color="primary" rounded :loading="loading" @click="reset">{{$t('components.authentication.reset_password.reset')}}</q-btn>
      </q-card-main>
      <q-card-separator />
    <q-card-actions>
      <q-btn flat @click="$router.push('/')">{{$t('components.authentication.reset_password.go_login')}}</q-btn>
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
        token: this.$route.params.token,
        email: ''
      },
      resetForm: {
        password: '',
        repeat_password: ''
      }
    }
  },
  validations: {
    resetForm: {
      password: { required, minLength: minLength(8), maxLength: maxLength(30) },
      repeat_password: { required, sameAsPassword: sameAs('password') }
    },
    params: {
      token: { required, minLength: minLength(150), maxLength: maxLength(150) },
      email: { required, email }
    }
  },
  created () {
    this.params.email = this.$_localStorage.get('forgot-password')
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
      this.$v.resetForm.$touch()
      if (this.$v.params.$error) {
        this.$q.notify({ message: this.$t('components.authentication.reset_password.invalid_url'), position: 'center' })
        return false
      }
      if (this.$v.resetForm.password.$error || this.$v.resetForm.repeat_password.$error) {
        this.$q.notify({ message: this.$t('components.authentication.reset_password.incorrect_input'), position: 'center' })
        return false
      }
      this.$v.resetForm.$reset()
      return true
    },
    reset () {
      if (this.valid()) {
        this.loading = true
        this.$axios
          .patch('/backend/resetPassword', {
            token: this.params.token,
            password: this.resetForm.password,
            password_confirmation: this.resetForm.repeat_password
          })
          .then(response => this.success())
          .catch(error => this.error(error))
      }
    },
    success () {
      this.$_localStorage.remove('forgot-password')
      this.$q.notify({message: this.$t('components.authentication.reset_password.successful_reset'), type: 'positive', position: 'center'})
      this.login()
    },
    login () {
      this.$store.dispatch('session/passwordLogin', {
        username: this.params.email,
        password: this.resetForm.password
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
