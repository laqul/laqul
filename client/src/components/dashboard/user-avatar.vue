<template>
  <div class="row croppie-component">
    <div class="col-xs-12">
      <img ref="croppie"/>
    </div>
    <form ref="form">
      <input @change="setUpFileUploader" ref="file" type="file" class="hidden" accept="image/x-png,image/gif,image/jpeg">
    </form>
    <div class="col-12">
      <div class="col-12 flex flex-center">
        <q-btn rounded outline :loading="loadingSelection" :disabled="loading" @click="openFile" color="primary" icon="image" :label="(uploadDisabled) ? $t('components.dashboard.user_avatar.select_image') : $t('components.dashboard.user_avatar.change_image')"/>
      </div>
      <div class="col-12 q-pt-md flex flex-center">
        <q-btn rounded :loading="loading" :disabled="uploadDisabled" @click="uploadFile" color="primary" icon="cloud" :label="$t('components.dashboard.user_avatar.save')"/>
      </div>
    </div>
  </div>
</template>
<style lang="scss">
.croppie-component {
  .q-btn {
    margin: 5px;
  }
  .croppie-container {
    margin-top: 30px;
    .cr-boundary {
      .cr-viewport {
        box-shadow: 0 0 0px 2000px #FFF!important;
      }
    }
  }
}
</style>

<script>
import {Croppie} from 'croppie'
import UPDATE_USER_AVATAR from '../../graphql/mutations/updateUserAvatar.gql'

export default {
  // name: 'ComponentName',
  data () {
    return {
      croppieInstance: null,
      newImage: null,
      uploadDisabled: true,
      loading: false,
      loadingSelection: false
    }
  },
  mounted () {
    this.newImage = this.image
    this.setUpCroppie()
  },
  computed: {
    image () {
      return this.$store.state.session.userInfo.avatar
    }
  },
  methods: {
    setUpCroppie () {
      this.croppieInstance = new Croppie(this.$refs.croppie, {
        enableExif: true,
        viewport: {
          width: 200,
          height: 200,
          type: 'circle'
        },
        boundary: {
          width: 220,
          height: 220
        },
        showZoomer: true,
        enableOrientation: true
      })
      this.croppieInstance.bind({
        url: this.newImage
      })
    },
    openFile () {
      this.$refs.file.click()
    },
    setUpFileUploader (e) {
      this.loadingSelection = true
      return new Promise((resolve) => {
        let files = e.target.files || e.dataTransfer.files
        if (!files.length) {
          return resolve(false)
        }
        resolve(files[0])
      }).then(file => this.createImage(file))
    },
    createImage (file) {
      if (!file) {
        return file
      }
      var reader = new FileReader()
      reader.onload = (e) => {
        this.newImage = e.target.result
        this.croppieInstance.destroy()
        this.setUpCroppie()
        this.uploadDisabled = false
        this.loadingSelection = false
      }
      reader.readAsDataURL(file)
    },
    uploadFile () {
      this.loading = true
      this.croppieInstance.result({
        type: 'canvas',
        size: 'viewport'
      }).then(image => this.saveAvatar(image))
        .then(response => this.success(response))
        .catch(error => {
          this.loading = false
          this.$errorHandler(this, error)
        })
    },
    saveAvatar (image) {
      return this.$apollo.mutate({
        mutation: UPDATE_USER_AVATAR,
        variables: {
          image
        }
      })
    },
    success (response) {
      this.uploadDisabled = true
      this.loading = false
      this.$refs.form.reset()
      this.$store.commit('session/setUserAvatar', response.data.updateUserAvatar[0].avatar)
      this.$q.notify({
        message: this.$t('components.dashboard.user_avatar.avatar_updated'),
        type: 'positive',
        position: 'center'
      })
    }
  }
}
</script>
