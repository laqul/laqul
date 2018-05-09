<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header class="no-shadow">
      <q-toolbar color="primary" inverted>
        <q-toolbar-title>
          {{$t('layouts.authentication.app_title')}}
        </q-toolbar-title>
        <q-btn-dropdown v-if="$config.language.multilanguage" icon="language" flat round>
          <!-- dropdown content -->
          <q-list link>
            <q-item v-close-overlay v-if="language.active" v-for="(language, index) in $config.language.languages" :key="index" @click.native="setLanguage(language.code)">
              <q-item-main>
                <q-item-tile label>{{language.name}}</q-item-tile>
              </q-item-main>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-toolbar>
    </q-layout-header>
    <q-page-container>
      <router-view />
    <q-modal v-model="showTerms" content-css="padding: 50px">
    <h4>{{$t('layouts.authentication.terms_conditions')}}</h4>
    <q-btn
      color="primary"
      @click="$store.commit('app/showTerms', false)"
      :label="$t('layouts.authentication.close')"/>
  </q-modal>
    </q-page-container>
  </q-layout>
</template>

<script>
export default {
  name: 'LayoutAuthentication',
  computed: {
    showTerms () {
      return this.$store.state.app.setup.showTerms
    }
  },
  methods: {
    setLanguage (code) {
      this.$store.commit('app/setLanguage', code)
    }
  }
}
</script>
