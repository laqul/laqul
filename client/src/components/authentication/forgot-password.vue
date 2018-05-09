<template>
  <q-card flat style="background: rgba(254, 254, 254, 0.9) !important;" inline color="white" text-color="dark">
    <q-card-title>
      {{$t('components.authentication.forgot_password.title')}}
    </q-card-title>
    <q-card-main>
      <q-alert v-if="sent" icon="email" type="positive" class="q-mb-sm">{{ $t('components.authentication.forgot_password.link_sent') }}</q-alert>
      <q-field class="q-mb-md" icon="email" :helper="$t('components.authentication.forgot_password.introduce_email')" :error="$v.emailForm.email.$error" :error-label="$t('components.authentication.forgot_password.invalid_email')">
        <q-input @keyup.enter="send" :float-label="$t('components.authentication.forgot_password.email')" v-model="emailForm.email" type="email" />
      </q-field>
      <q-btn color="primary" rounded :loading="loading" @click="send">{{$t('components.authentication.forgot_password.sendme_email')}}</q-btn>
    </q-card-main>
    <q-card-separator />
    <q-card-actions>
      <q-btn flat @click="$router.push('/')">{{$t('components.authentication.forgot_password.go_login')}}</q-btn>
    </q-card-actions>
  </q-card>
</template>

<script>
import { required, email } from 'vuelidate/lib/validators'
export default {
  data () {
    return {
      loading: false,
      sent: false,
      emailForm: {
        email: ''
      }
    }
  },
  validations: {
    emailForm: {
      email: { required, email }
    }
  },
  methods: {
    valid () {
      this.$v.emailForm.$touch()
      if (this.$v.emailForm.$error) {
        this.$q.notify({
          message: this.$t('components.authentication.forgot_password.incorrect_input'),
          position: 'center'
        })
        return false
      } else {
        this.$v.emailForm.$reset()
        return true
      }
    },
    send () {
      if (this.valid()) {
        this.loading = true
        this.$axios
          .post('/backend/forgotPassword', { email: this.emailForm.email })
          .then(response => this.success())
          .catch(error => {
            this.loading = false
            this.$errorHandler(this, error)
          })
      }
    },
    success () {
      this.$_localStorage.set('forgot-password', this.emailForm.email)
      this.emailForm.email = ''
      this.sent = true
      this.loading = false
      this.$q.notify({
        message: this.$t('components.authentication.forgot_password.link_sent'),
        type: 'positive',
        position: 'center'
      })
    }
  }
}
</script>
