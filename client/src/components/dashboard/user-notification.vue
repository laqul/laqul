<template>
    <q-item link separator @click.native="open">
      <q-item-side icon="message" :color="data.color" />
      <q-item-main :label="data.title" :sublabel="data.body" />
    </q-item>
</template>

<script>
export default {
  props: {
    data: {
      type: Object
    }
  },
  methods: {
    open () {
      // open
    },
    success () {
      // success
    }
  }
}
</script>
