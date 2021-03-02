<template>
  <v-container fluid class="login-bg d-flex justify-center align-center">
    <v-row class="justify-center align-center">
      <v-col cols="12" lg="4" class="align-center">
        <p class="text-left white--text">教育是什么，往简单方面说，只需一句话，就是养成良好的习惯。</p>
        <p class="text-right white--text">——布鲁纳（教育家）</p>
      </v-col>
      <v-col cols="12" lg="4">
        <v-row class="justify-center">
          <v-col md="7" sm="12" xs="12">
            <v-card>
              <v-tabs
                v-model="tab"
                background-color="light-blue accent-4"
                centered
                dark
                icons-and-text
              >
                <v-tabs-slider></v-tabs-slider>
                <v-tab href="#qr-login">
                  扫码登录
                  <v-icon>mdi-qrcode</v-icon>
                </v-tab>
                <v-tab href="#phone-login">
                  账户登录
                  <v-icon>mdi-account</v-icon>
                </v-tab>
              </v-tabs>
              <v-tabs-items v-model="tab">
                <v-tab-item value='qr-login' >
                  <v-card flat class="pb-8 d-flex justify-center">
                    <qrcode value="http://47.111.233.60" :options="{ width: 350 }"></qrcode>
                  </v-card>
                </v-tab-item>
                
                <v-tab-item value='phone-login' >
                  <v-card flat>
                    <v-card-text ref="form">
                      <v-text-field
                        v-model="phoneNumber"
                        :rules="[rules.required]"
                        label="帐号"
                        :counter="11"
                        prepend-inner-icon="mdi-phone"
                        :error="true"
                      ></v-text-field>
                      <v-text-field
                        v-model="password"
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="[rules.required, rules.min]"
                        :type="show1 ? 'text' : 'password'"
                        name="password"
                        label="密码"
                        hint="至少8个字符"
                        counter
                        prepend-inner-icon="mdi-key-chain-variant"
                        @click:append="show1 = !show1"
                        :error="false"
                      ></v-text-field>
                      <v-checkbox
                        v-model="checkbox"
                        value="1"
                        label="已阅读并同意《用户服务协议》和《隐私》"
                        type="checkbox"
                        :rules="[rules.required]"
                      ></v-checkbox>

                      <v-btn color="primary" block @click="login" :loading="isLogging">
                        <v-icon left>
                          mdi-login
                        </v-icon> 
                        登录
                      </v-btn>
                      <v-row class="justify-end pa-3">
                        <v-btn color="primary" text class="align-right">
                          忘记密码?
                        </v-btn>
                      </v-row>
                      <v-row class="justify-center align-center ">
                        <span>—————</span>
                        <span class="px-2">  使用第三方账号登录  </span>
                        <span>—————</span>
                      </v-row>
                      <v-row class="justify-center align-center pt-1 pb-4">
                        <v-btn color="primary" text>
                          <v-icon left>
                            mdi-wechat
                          </v-icon> 
                          企业微信
                        </v-btn>
                      </v-row>
                    </v-card-text>
                  </v-card>
                </v-tab-item>
              </v-tabs-items>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters } from 'vuex';
import { loginApi } from '~/api/auth';

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    tab : 'phone-login',
    phoneNumber : '',
    checkbox : null,
    show1 : false,
    password : '',
    rules : {
      required: value => !!value || '必需的。',
      min: v => v.length >= 8 || '最少8个字符',
    },
    isLogging : false,
    loginFormHasErrors : false,
    errorMessages : '',
  }),

  computed: {
    form () {
      return {
        phoneNumber: this.phoneNumber,
        password: this.password,
      }
    },

    ...mapGetters({
      authenticated: 'auth/check'
    })
  },

  methods: {
    async login(){
      this.isLogging = true;
      let payload = {
        phoneNumber : this.phoneNumber,
        password : this.password
      };
          
      await loginApi(payload)
        .then(res=>{
          console.log(res)
          this.isLogging = false;
        })
        .catch(err=>{
          console.log(err)
          this.isLogging = false;
        })
    }
  },
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
