import Vue from 'vue'
import VueTimeago from 'vue-timeago'

Vue.use(VueTimeago, {
    name: "Timeago", // Component name, `Timeago` by default
    locale: "en", // Default locale
    locales: {
      'zhCN': require('date-fns/locale/zh-CN'),
    }
  })
