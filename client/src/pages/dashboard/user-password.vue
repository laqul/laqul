<template>
  <q-page padding>
    <q-alert v-if="isSocial" icon="warning" type="warning" class="q-mb-sm">{{ $t('pages.dashboard.user_password.change_password_unavailable') }}</q-alert>
    <user-password v-else/>
  </q-page>
</template>

<script>
import UserPassword from 'components/dashboard/user-password'
export default {
  // name: 'PageName',
  components: {
    UserPassword
  },
  computed: {
    isSocial () {
      if (this.$store.state.session.userSession.accessToken) {
        return this.$store.state.session.userSession.accessToken.social
      }
      return false
    }
  }
}
</script>
