<template>
  <div class="fixed-center text-center">
    <p>
      <q-icon color="primary" size="10rem" name="mood_bad"/>
    </p>
    <p class="q-display-2 text-faded">{{$t('pages.errors.e404.message')}}</p>
    <q-btn
      color="primary" rounded
      @click="$router.push('/')">{{$t('pages.errors.e404.go_back')}}</q-btn>
  </div>
</template>
