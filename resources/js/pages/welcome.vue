<template>
  <v-container fluid class="login-bg d-flex justify-center align-center py-0">

    <v-row v-if="$isMobile()" class="w-100 h-100 bg-white align-center justify-center">
      <v-col cols="12">
        <div class="d-flex justify-center mb-10">
          <img :src="`${baseUrl}/asset/img/favicon_white.png`" alt="upload-video-icon" class="mo-login-logo"/>
        </div>
         <v-card flat>
          <v-card-text ref="form">
            <v-form v-model="isFormValid" @submit.prevent="login">
              <p class="mb-0">帐号</p>
              <v-text-field
                class="pt-0 mt-0"
                color="#7879ff"
                single-line
                v-model="phoneNumber"
                label="帐号"
                :rules="[rules.required]"
              ></v-text-field>
              <p class="mb-0">密码</p>
              <v-text-field
                class="pt-0 mt-0"
                color="#7879ff"
                single-line
                v-model="password"
                name="password"
                label="请输入登录密码"
                hint="至少8个字符"
                :rules="[rules.required, rules.min]"
                :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                :type="show1 ? 'text' : 'password'"
                @click:append="show1 = !show1"
              ></v-text-field>
              <v-checkbox
                v-model="agreeTerms"
                label="已阅读并同意《用户服务协议》和《隐私》"
                type="checkbox"
                color="#7879ff"
                :rules="[rules.required]"
              >
                <template v-slot:label>
                  <div @click.stop="">
                    已阅读并同意
                    <a
                      href="#"
                      style="color: #7879ff"
                      @click.prevent="terms = true"
                    >《用户服务协议》</a>
                    和
                    <a
                      href="#"
                      style="color: #7879ff"
                      @click.prevent="conditions = true"
                    >《隐私》</a>
                  </div>
                </template>
              </v-checkbox>
              <v-btn color="#7879ff" rounded dark large block type="submit" :loading="isLogging">
                立即登录
              </v-btn>
            </v-form>
            <v-row class="justify-end pa-3">
              <v-btn text class="align-right mt-4 ">
                忘记密码?
              </v-btn>
            </v-row>
            <v-row class="justify-center align-center ">
              <v-divider light></v-divider>
              <span class="px-2">  使用第三方账号登录  </span>
              <v-divider light></v-divider>
            </v-row>
            <v-row class=" justify-start align-center pt-1 pb-4">
              <v-img :src="`${baseUrl}/asset/img/wechat.svg`" max-width="45" class="mt-3"></v-img>
            </v-row>
            <v-dialog v-model="terms" width="90%" >
              <v-card>
                <v-card-title class="title">
                  Terms
                </v-card-title>
                <v-card-text
                  v-for="n in 5"
                  :key="n"
                >
                  {{ content }}
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="terms = false"
                  >
                    Ok
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog
              v-model="conditions"
              width="90%"
            >
              <v-card>
                <v-card-title class="title">
                  Conditions
                </v-card-title>
                <v-card-text
                  v-for="n in 5"
                  :key="n"
                >
                  {{ content }}
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn
                    text
                    color="primary"
                    @click="conditions = false"
                  >
                    Ok
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row v-else class="justify-center align-center">
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
                background-color="#7879ff"
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
                    <qrcode value="http://8.131.231.180/" :options="{ width: 350 }"></qrcode>
                  </v-card>
                </v-tab-item>
                
                <v-tab-item value='phone-login' >
                  <v-card flat>
                    <v-card-text ref="form">
                      <v-form v-model="isFormValid" @submit.prevent="login">
                        <v-text-field
                          v-model="phoneNumber"
                          label="帐号"
                          color="#7879ff"
                          prepend-inner-icon="mdi-phone"
                          :rules="[rules.required]"
                          :counter="11"
                        ></v-text-field>
                        <v-text-field
                          v-model="password"
                          name="password"
                          label="密码"
                          hint="至少8个字符"
                          counter
                          color="#7879ff"
                          prepend-inner-icon="mdi-key-chain-variant"
                          :rules="[rules.required, rules.min]"
                          :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                          :type="show1 ? 'text' : 'password'"
                          @click:append="show1 = !show1"
                        ></v-text-field>
                        <v-checkbox
                          color="#7879ff"
                          v-model="agreeTerms"
                          label="已阅读并同意《用户服务协议》和《隐私》"
                          type="checkbox"
                          :rules="[rules.required]"
                        >
                          <template v-slot:label>
                            <div @click.stop="">
                              已阅读并同意
                              <a
                                href="#"
                                @click.prevent="terms = true"
                                style="color: #7879ff"
                              >《用户服务协议》</a>
                              和
                              <a
                                href="#"
                                @click.prevent="conditions = true"
                                style="color: #7879ff"
                              >《隐私》</a>
                            </div>
                          </template>
                        </v-checkbox>
                        <v-btn color="#7879ff" :dark="isFormValid" block type="submit" :loading="isLogging" :disabled="!isFormValid">
                          <v-icon left>
                            mdi-login
                          </v-icon> 
                          登录
                        </v-btn>
                      </v-form>
                      <v-row class="justify-end pa-3">
                        <v-btn color="#7879ff" text class="align-right">
                          忘记密码?
                        </v-btn>
                      </v-row>
                      <v-row class="justify-center align-center ">
                        <span>—————</span>
                        <span class="px-2">  使用第三方账号登录  </span>
                        <span>—————</span>
                      </v-row>
                      <v-row class="justify-center align-center pt-1 pb-4">
                        <v-btn color="#7879ff" text>
                          <v-icon left>
                            mdi-wechat
                          </v-icon> 
                          企业微信
                        </v-btn>
                      </v-row>
                      <v-dialog v-model="terms" width="70%" >
                        <v-card>
                          <v-card-title class="title">
                            Terms
                          </v-card-title>
                          <v-card-text
                            v-for="n in 5"
                            :key="n"
                          >
                            {{ content }}
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                              text
                              color="primary"
                              @click="terms = false"
                            >
                              Ok
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                      <v-dialog
                        v-model="conditions"
                        width="70%"
                      >
                        <v-card>
                          <v-card-title class="title">
                            Conditions
                          </v-card-title>
                          <v-card-text
                            v-for="n in 5"
                            :key="n"
                          >
                            {{ content }}
                          </v-card-text>
                          <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                              text
                              color="primary"
                              @click="conditions = false"
                            >
                              Ok
                            </v-btn>
                          </v-card-actions>
                        </v-card>
                      </v-dialog>
                    </v-card-text>
                  </v-card>
                </v-tab-item>
              </v-tabs-items>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <v-snackbar
      timeout="3000"
      v-model="loginFailed"
      color="error"
      absolute
      top
    >
      Login Failed
    </v-snackbar>
  </v-container>
</template>

<script>

import { mapGetters } from 'vuex';
import { loginApi } from '~/api/auth';

export default {
  middleware: 'guest',
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    baseUrl:window.Laravel.base_url,
    tab : 'phone-login',
    phoneNumber : '',
    password : '',
    show1 : false,
    agreeTerms : true,
    remember : false,
    rules : {
      required: value => !!value || '必需的。',
      min: v => v.length >= 8 || '最少8个字符',
    },
    isLogging : false,
    isFormValid : false,
    terms : false,
    conditions : false,
    loginFailed : false,
    schoolData : {},
    schoolTree : [],
    chooseableSchoolTree : [],
    content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Curabitur sodales ligula in libero. Sed dignissim lacinia nunc.',

  }),

  computed: {
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
          this.isLogging = false;
          // Save the token.
          this.$store.dispatch('auth/saveToken', {
            token: res.data.token,
            remember: this.remember
          })
          // Fetch the user.
          this.$store.dispatch('auth/saveUserState', res.data.user)
          this.$store.dispatch('schooltree/storeSchoolData', res.data.schoolTree);
          res.data.alarmData.map(alarm => {
            alarm.content = JSON.parse(alarm.content);
          })
          this.$store.dispatch('alarm/storeAlarm', res.data.alarmData);

          //save MemberData
          if( res.data.memberData !== null && (res.data.user.roleId == 3 || res.data.user.roleId == 4 || res.data.user.roleId == 5) ) {
            this.$store.dispatch('schooltree/storeMemberData', res.data.memberData);
          }
          
          // Redirect home.
          this.$router.push({ name: 'home' })
        })
        .catch(err=>{
          //console.log(err);
          this.isLogging = false;
          this.$snackbar.showMessage({content: "登录失败", color: "error"})
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
