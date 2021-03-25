import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import Vuetify from 'vuetify'
import common from './helper/common'
import '@mdi/font/css/materialdesignicons.css'
import zhHans from 'vuetify/es5/locale/zh-Hans'
Vue.mixin(common)

import '~/plugins'
import '~/components'

Vue.use(Vuetify);

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'eschoolKey',
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  // vuetify,
  i18n,
  store,
  router,
  ...App,
   vuetify: new Vuetify({
    icons: {
      iconfont: 'mdi', // default - only for display purposes
    },
    lang: {
      locales: { zhHans },
      current: 'zhHans',
    },
  }),
})
