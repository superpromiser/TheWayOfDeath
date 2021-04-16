import axios from 'axios'
import store from '~/store'
import router from '~/router'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response
  // console.log(this.$isMobile)
  if (status >= 500) {
    Swal.fire({
      type: 'error',
      title: "哎呀",
      text: "出了些问题",
      reverseButtons: true,
      confirmButtonText: "确认",
      cancelButtonText: "取消"
    })
  }

  if (status === 401 && store.getters['auth/check']) {
    Swal.fire({
      type: 'warning',
      title: "会话已过期！",
      text: "请再次登录以继续",
      reverseButtons: true,
      confirmButtonText: "确认",
      cancelButtonText: "取消"
    }).then(() => {
      store.commit('auth/LOGOUT')

      router.push({ name: 'login' })
    })
  }

  return Promise.reject(error)
})
