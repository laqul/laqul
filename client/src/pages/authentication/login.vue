<template>
  <q-page class="page">
    <div class="row cont">
      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 flex content-center justify-center login">
        <img src="~assets/logo.png" alt="" height="80">
        <login class="login-box"/>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xl-9 bg"></div>
    </div>
  </q-page>
</template>
<script>
import Login from 'components/authentication/login'
export default {
  components: {
    Login
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
    .login-box {
      width: 95%;
    }
  }
  @media screen and (min-width: 992px) {
    .login {
      .login-box {
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
