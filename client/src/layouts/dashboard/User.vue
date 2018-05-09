<template>
  <q-layout>
    <q-tabs inverted align="justify">
        <q-route-tab name="tab-1" :label="$t('layouts.user.avatar')" icon="face" to="/Panel/User/Avatar" exact slot="title" />
        <q-route-tab name="tab-2" :label="$t('layouts.user.info')" icon="format_list_bulleted" to="/Panel/User/Info" exact slot="title" />
        <q-route-tab name="tab-3" :label="$t('layouts.user.password')" icon="vpn_key" to="/Panel/User/Password" exact slot="title" />
      </q-tabs>
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>
<style lang="scss" scoped>
.q-layout {
  min-height: calc(100vh - 50px)!important;
  .q-layout-page {
    min-height: calc(100vh - 160px)!important;
  }
}
</style>
