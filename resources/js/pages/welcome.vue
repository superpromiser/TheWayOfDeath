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
                <v-tab href="#tab-1">
                  扫码登录
                  <v-icon>mdi-qrcode</v-icon>
                </v-tab>
                <v-tab href="#tab-2">
                  账户登录
                  <v-icon>mdi-account</v-icon>
                </v-tab>
              </v-tabs>
              <v-tabs-items v-model="tab">
                <v-tab-item value='tab-1' >
                  <v-card flat class="pb-8 d-flex justify-center">
                    <qrcode value="http://47.111.233.60" :options="{ width: 350 }"></qrcode>
                  </v-card>
                </v-tab-item>
                
                <v-tab-item value='tab-2' >
                  <v-card flat>
                    <v-card-text>
                      <v-text-field
                        v-model="phoneNumber"
                        :rules="[rules.required]"
                        label="帐号"
                        :counter="11"
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
                        @click:append="show1 = !show1"
                      ></v-text-field>
                      <v-checkbox
                        v-model="checkbox"
                        :error-messages="errors"
                        value="1"
                        label="已阅读并同意《用户服务协议》和《隐私》"
                        type="checkbox"
                        :rules="[rules.required]"
                      ></v-checkbox>

                      <v-btn color="primary" block>
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

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    tab: 'tab-2',
    phoneNumber: '',
    checkbox: null,
    show1: false,
    password: '',
    rules: {
      required: value => !!value || '必需的。',
      min: v => v.length >= 8 || '最少8个字符',
    },
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),

  methods: {
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
