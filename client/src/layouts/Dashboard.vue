<template>
  <q-layout view="lHh Lpr lFf">
    <q-layout-header class="no-shadow" reveal>
      <q-toolbar color="primary">
        <q-btn icon="menu" flat dense round @click="leftDrawerOpen = !leftDrawerOpen"/>
        <q-toolbar-title>
          {{$t('layouts.dashboard.app_title')}}
        </q-toolbar-title>
        <q-btn icon="notifications" flat dense round @click="rightDrawerOpen = !rightDrawerOpen">
          <q-chip v-if="notifications.length" floating color="red">{{ notifications.length }}</q-chip>
        </q-btn>
        <q-btn-dropdown v-if="$config.language.multilanguage" icon="language" flat round>
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

    <q-layout-drawer side="left"
      v-model="leftDrawerOpen"
      content-class="bg-white">
      <q-scroll-area class="fit">
        <div class="flex flex-center q-mb-md">
          <img src="~assets/logo.png" alt="" width="200">
        </div>
        <div class="column flex-center profile">
          <img :src="userInfo.avatar" class="avatar q-mb-md"/>
          <p class="q-subheading ellipsis text-faded">{{userInfo.name}}</p>
          <q-btn @click="$router.push('/Panel/User')" outline rounded color="primary" icon="settings" size="sm" :label="$t('layouts.dashboard.my_account')" class="q-mb-sm"/>
          <q-btn flat @click="logout('logout'), leftDrawerOpen = false" icon="exit_to_app" size="sm" :label="$t('layouts.dashboard.exit')"/>
        </div>
        <q-list-header>{{$t('layouts.dashboard.sections')}}</q-list-header>
        <q-item exact to="/Panel">
          <q-item-side icon="dashboard" />
          <q-item-main :label="$t('layouts.dashboard.dashboard')" :sublabel="$t('layouts.dashboard.dashboard_sub')" />
        </q-item>
        <div class="fixed-bottom bottom-drawer bg-primary flex flex-center">
          <q-btn @click="logout('logoutAll'), leftDrawerOpen = false" icon="phonelink_erase" size="sm" color="white" flat :label="$t('layouts.dashboard.exit_all')"/>
        </div>
      </q-scroll-area>
    </q-layout-drawer>

    <q-layout-drawer side="right"
      v-model="rightDrawerOpen"
      content-class="bg-white">
      <q-scroll-area class="fit">
        <q-list-header>{{$t('layouts.dashboard.notifications')}}</q-list-header>
        <user-notification @click.native="rightDrawerOpen = false" :data="notification" v-for="(notification, key) in notifications" :key="key"/>
      </q-scroll-area>
    </q-layout-drawer>
    <q-page-container>
      <q-alert
          v-if="!cloudMessaging.notificationPromptShowed && fcmAlert"
          type="warning"
          icon="message"
          :actions="[{ label: $t('layouts.dashboard.activate'), icon: 'done', handler () {
            fcmAskForPermission()
          } },
          { label: $t('layouts.dashboard.close'), icon: 'close', handler () { fcmAlert = false }}]">
         {{$t('layouts.dashboard.activate_notifications')}}
      </q-alert>

      <q-alert
          v-if="cloudMessaging.notificationsBlocked && fcmAlert"
          type="negative"
          icon="message"
          :actions="[{ label: $t('layouts.dashboard.unblock'), icon: 'lock_open', handler () {} }, { label: $t('layouts.dashboard.close'), icon: 'close', handler () { fcmAlert = false } }]">
          {{$t('layouts.dashboard.blocked_notifications')}}
      </q-alert>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import dashboardBoot, { fcmAskForPermission } from '../dashboard-boot'
import logout from '../session/logout'
import UserNotification from 'components/dashboard/user-notification'

export default {
  name: 'LayoutDashboard',
  components: {
    UserNotification
  },
  data () {
    return {
      leftDrawerOpen: false,
      rightDrawerOpen: false,
      fcmAlert: true
    }
  },
  computed: {
    cloudMessaging () {
      return this.$store.state.session.cloudMessaging
    },
    userInfo () {
      return this.$store.state.session.userInfo
    },
    notifications () {
      return this.$store.state.session.userNotifications
    }
  },
  methods: {
    fcmAskForPermission,
    logout,
    setLanguage (code) {
      this.$store.commit('app/setLanguage', code)
    }
  },
  created () {
    dashboardBoot().catch(error => this.$errorHandler(this, error))
  }
}
</script>

<style lang="scss" scoped>
.profile {
  height: 200px;
  .avatar {
    width: 80px;
    height: 80px;
  }
}
.bottom-drawer {
  width: 100%;
  height: 50px;
}
</style>
