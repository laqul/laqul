<template>
  <q-card flat color="white" text-color="dark">
    <q-card-title>
      {{$t('components.dashboard.user_password.title')}}
    </q-card-title>
    <q-card-main>
      <q-field class="q-mb-md" icon="lock" :error="$v.form.current_password.$error" :error-label="$t('components.dashboard.user_password.invalid_password')">
        <q-input :float-label="$t('components.dashboard.user_password.current_password')" v-model="form.current_password" type="password" />
      </q-field>
      <q-field class="q-mb-md" icon="lock" :error="$v.form.password.$error" :error-label="$t('components.dashboard.user_password.invalid_password')">
        <q-input :float-label="$t('components.dashboard.user_password.new_password')" v-model="form.password" type="password" />
      </q-field>
      <q-field class="q-mb-md" inset="icon" :error="$v.form.password_confirmation.$error" :error-label="$t('components.dashboard.user_password.password_mismatch')">
        <q-input :float-label="$t('components.dashboard.user_password.password_confirmation')" v-model="form.password_confirmation" type="password" />
      </q-field>
      <q-btn color="primary" rounded :loading="loading" @click="update">{{$t('components.dashboard.user_password.change')}}</q-btn>
    </q-card-main>
  </q-card>
</template>

<script>
import {
  required,
  minLength,
  maxLength,
  sameAs
} from 'vuelidate/lib/validators'
import UPDATE_USER_PASSWORD from '../../graphql/mutations/updateUserPassword.gql'
export default {
  data () {
    return {
      loading: false,
      form: {
        current_password: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  validations: {
    form: {
      current_password: { required, minLength: minLength(8), maxLength: maxLength(30) },
      password: { required, minLength: minLength(8), maxLength: maxLength(30) },
      password_confirmation: { required, sameAsPassword: sameAs('password') }
    }
  },
  methods: {
    reset () {
      this.form = {
        current_password: '',
        password: '',
        password_confirmation: ''
      }
    },
    valid () {
      this.$v.form.$touch()
      if (
        this.$v.form.current_password.$error ||
        this.$v.form.password.$error ||
        this.$v.form.password_confirmation.$error
      ) {
        this.$q.notify({ message: this.$t('components.dashboard.user_password.incorrect_input'), position: 'center' })
        return false
      } else {
        this.$v.form.$reset()
        return true
      }
    },
    update () {
      if (this.valid()) {
        this.loading = true
        this.$apollo.mutate({
          mutation: UPDATE_USER_PASSWORD,
          variables: {
            current_password: this.form.current_password,
            password: this.form.password,
            password_confirmation: this.form.password_confirmation
          }
        }).then(response => this.success())
          .catch(() => {
            this.loading = false
          })
      }
    },
    success () {
      this.$q.notify({
        message: this.$t('components.dashboard.user_password.password_updated'),
        type: 'positive',
        position: 'center'
      })
      this.loading = false
      this.reset()
    }
  }
}
</script>
