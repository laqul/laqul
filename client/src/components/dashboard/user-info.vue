<template>
  <q-card flat color="white" text-color="dark">
    <q-card-title>
      {{$t('components.dashboard.user_info.title')}}
    </q-card-title>
    <q-card-main>
      <q-field class="q-mb-md" :error="$v.info.name.$error" :error-label="$t('components.dashboard.user_info.invalid_name')">
        <q-input :float-label="$t('components.dashboard.user_info.name')" v-model="info.name" type="text" />
      </q-field>
      <q-btn color="primary" rounded :loading="loading" @click="update">{{$t('components.dashboard.user_info.update')}}</q-btn>
    </q-card-main>
  </q-card>
</template>

<script>
import {
  required,
  minLength,
  maxLength
} from 'vuelidate/lib/validators'
import UPDATE_USER_INFO from '../../graphql/mutations/updateUserInfo.gql'
export default {
  data () {
    return {
      loading: false
    }
  },
  validations: {
    info: {
      name: { required, minLength: minLength(4), maxLength: maxLength(30) }
    }
  },
  computed: {
    info () {
      return this.$store.state.session.userInfo
    }
  },
  methods: {
    valid () {
      this.$v.info.$touch()
      if (this.$v.info.name.$error) {
        this.$q.notify({ message: this.$t('components.dashboard.user_info.incorrect_input'), position: 'center' })
        return false
      } else {
        this.$v.info.$reset()
        return true
      }
    },
    update () {
      if (this.valid()) {
        this.loading = true
        this.$apollo.mutate({
          mutation: UPDATE_USER_INFO,
          variables: {
            name: this.info.name
          }
        }).then(response => this.success(response))
          .catch(() => {
            this.loading = false
          })
      }
    },
    success (response) {
      this.loading = false
      this.$store.commit('session/setUserName', response.data.updateUserInfo[0].name)
      this.$q.notify({
        message: this.$t('components.dashboard.user_info.info_updated'),
        type: 'positive',
        position: 'center'
      })
    }
  }
}
</script>
