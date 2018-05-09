<template>
  <q-page padding>
    <div class="fixed-center text-center">
    <p>
      <q-icon color="primary" size="10rem" name="fingerprint"/>
    </p>
    <p class="q-display-1 text-faded">{{$t('pages.authentication.social_login.social_auth')}}</p>
  </div>
  </q-page>
</template>

<script>
export default {
  // name: 'PageName',
  mounted () {
    this.processCode()
  },
  methods: {
    processCode () {
      var params = {}
      var search = decodeURIComponent(window.location.href.slice(window.location.href.indexOf('?') + 1))
      var definitions = search.split('&')
      definitions.forEach((val, key) => {
        var parts = val.split('=', 2)
        params[parts[0]] = parts[1]
      })
      if ('code' in params && 'state' in params) {
        let cleanState = params['state'].replace('#_', '')
        this.callApi(params['code'], cleanState)
        return true
      }
      this.$router.push('/')
    },
    callApi (code, platform) {
      this.$q.loading.show({
        message: this.$t('pages.authentication.social_login.loading_text')
      })
      this.$store.dispatch('session/socialLogin', {
        code,
        platform,
        timezone: this.$moment.tz.guess()
      }).then(response => {
        this.$q.loading.hide()
        this.$router.push('/Panel')
      }).catch(error => {
        this.$q.loading.hide()
        this.$errorHandler(this, error)
        this.$router.push('/')
      })
    }
  }
}
</script>

<style>

</style>
