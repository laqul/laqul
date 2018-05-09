<template>
  <q-page class="page">
    <div class="row cont">
      <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xl-9 bg"></div>
      <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-3 flex content-center justify-center register">
        <img src="~assets/logo.png" alt="" height="80">
        <email-verification class="email-box"/>
      </div>
    </div>
  </q-page>
</template>

<script>
import EmailVerification from 'components/authentication/email-verification'
export default {
  components: {
    EmailVerification
  }
}
</script>
<style lang="scss" scoped>
.cont {
  .register {
    height: calc(100vh - 51px);
    @media screen and (min-width: 2377px) {
      max-width: 594px;
    }
    .email-box {
      width: 95%;
    }
  }
  @media screen and (min-width: 992px) {
    .register {
      .email-box {
        width: 400px;
      }
    }
  }
  @media screen and (max-width: 767px) {
    .register {
      background: url(~assets/register-bg.jpg);
      background-repeat: no-repeat;
      background-size: cover;
      background-position: right;
    }
    @media (orientation: landscape) {
      .register {
        height: 100%;
      }
    }
  }

  @media screen and (min-width: 768px) {
    .bg {
      background: url(~assets/register-bg.jpg);
      background-repeat: no-repeat;
      background-size: cover;
      background-position: right;
    }
  }
}
</style>
