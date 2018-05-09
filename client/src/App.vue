<template>
  <div id="q-app">
    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  watch: {
    '$route' (toRoute, fromRoute) {
      window.document.title = this.$t(this.$route.name + '.title')
    }
  }
}
</script>

<style>
</style>
