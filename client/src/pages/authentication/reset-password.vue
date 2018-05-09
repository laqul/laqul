<template>
  <q-page class="page">
    <div class="row cont">
      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 flex content-center justify-center login">
        <img src="~assets/logo.png" alt="" height="80">
        <reset-password class="reset-box"/>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xl-9 bg"></div>
    </div>
  </q-page>
</template>
<script>
import ResetPassword from 'components/authentication/reset-password'
export default {
  components: {
    ResetPassword
  }
}
</script>
<style lang="scss" scoped>
.cont {
  .login {
    height: calc(100vh - 51px);
    @media screen and (min-width: 2377px) {
      max-width: 594px;
    }
    .reset-box {
      width: 95%;
    }
  }
  @media screen and (min-width: 992px) {
    .login {
      .reset-box {
        width: 400px;
      }
    }
  }
  @media screen and (max-width: 767px) {
    .login {
      background: url(~assets/login-bg.jpg);
      background-repeat: no-repeat;
      background-size: cover;
      background-position: left;
    }
    @media (orientation: landscape) {
      .login {
        height: 100%;
      }
    }
  }

  @media screen and (min-width: 768px) {
    .bg {
      background: url(~assets/login-bg.jpg);
      background-repeat: no-repeat;
      background-size: cover;
      background-position: left;
    }
  }
}
</style>
